<template>
    <el-row :gutter="20">
      <el-col :span="5">
        <el-aside width="200px">
          <el-menu :default-openeds="['1']">
            <el-submenu index="1">
              <template slot="title"><i class="el-icon-menu"></i>Channels</template>
              <el-menu-item-group>
                    <el-menu-item 
                      index=""
                      v-for="channel in channels" 
                      @click="getChannel(channel._id)" 
                      v-bind:data="channel" 
                      v-bind:key="channel._id">
                        {{ channel.label }}
                      </el-menu-item>
              </el-menu-item-group>
            </el-submenu>
          </el-menu>
        </el-aside>
      </el-col>

      <el-col :span="15">
        <el-container>

          <el-header style="text-align: right; font-size: 12px">
            <span>Welcome {{user.fullname}} </span>
            <el-dropdown>
              <i class="el-icon-setting" style="margin-right: 15px"></i>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item @click.native="home()">Homepage</el-dropdown-item>
                <el-dropdown-item @click.native="users()">List users</el-dropdown-item>
                <el-dropdown-item @click.native="profile()">Profile</el-dropdown-item>
                <el-dropdown-item @click.native="signout()">Logout</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </el-header>

          <el-main>
              <el-tabs v-model="activeName" @tab-click="handleClick">
                <el-tab-pane label="Channel" name="first">

                    <el-form @submit.prevent.native="addChannelPost">
                        <el-form-item label="Message">
                            <el-input v-model="message.message" id="message" clearable></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="addChannelPost" value="submit">Send</el-button>
                        </el-form-item>
                    </el-form>
                    <div v-for="m in messages.slice().reverse()">

                        <el-form id="chat">
                            <el-form-item v-if="(editMode.id==m._id)">
                                <el-input @keyup.enter.native="saveMessage(m._id)" v-model="editMsg.message" v-bind:id="message._id" :placeholder="m.message" clearable></el-input>
                                <div style="text-align: center;padding-top:10px;">
                                    <el-button type="success" @click="saveMessage(m._id)" v-bind:id="message._id">update</el-button>
                                    <el-button type="danger" @click="cancelEdit(m._id)" v-bind:id="message._id">cancel</el-button>
                                </div>
                            </el-form-item>
                            <el-form-item v-else :label="getUser(m.member_id)">
                                <div style="text-align: center">
                                    <vue-markdown v-bind:source="m.message"></vue-markdown>
                                </div>
                                <div style="text-align: right">
                                    <el-button type="warning" @click="editMessage(m._id)" v-bind:id="message._id">edit</el-button>
                                    <el-button type="danger" @click="deleteMessage(m._id)">delete</el-button>
                                </div>
                                <div style="text-align: right">
                                    {{m.updated_at | formatDate}}
                                </div>
                            </el-form-item>
                        </el-form>

                    </div>
                    
                </el-tab-pane>
                <el-tab-pane label="Details" name="second">
                    <h1>This is channel : {{channelInfo.topic}}</h1>
                    Label : {{channelInfo.label}}
                </el-tab-pane>
                <el-tab-pane label="Edit" name="third">

                    <el-form>
                        <el-form-item label="Label">
                            <el-input @keyup.enter.native="editChannel" v-model="channel.label" id="label" clearable></el-input>
                        </el-form-item>
                        <el-form-item label="Topic">
                            <el-input @keyup.enter.native="editChannel" v-model="channel.topic" id="topic" clearable></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="editChannel">Update</el-button>
                        </el-form-item>
                    </el-form>

                    <el-alert v-if="created" title="Channel updated" type="success" center></el-alert>
                    <el-alert v-if="error" title="An error has occured, please try again. If it persists contact a sytem administrator." type="error" center></el-alert>

                    <div style="text-align: right">
                        <el-button type="danger" @click="del()" round>Delete channel</el-button>
                    </div>
                </el-tab-pane>
              </el-tabs>
          </el-main>
        </el-container>
      </el-col>
    </el-row>
</template>

<script>
  import api from '../api'
  import VueMarkdown from 'vue-markdown'

  export default {
    name: 'Channel',
    data() {
      return {
        channel: {label: '', topic: ''},
        channelInfo: {},
        channels: {},
        messages: {},
        message: {message: '', user: ''},
        editMsg: {message: ''},
        editMode: {
            id: ''
        },
        user: {},
        allUsers: {},
        activeName: 'first',
        created: false,
        error: false
      }
    },
    components: { 'vue-markdown' :  VueMarkdown},
    created() {
        api.get('/channels/' + this.$route.params.id).then((response) => {
            this.channelInfo = response.data
        })
        api.get('/channels/' + this.$route.params.id + '/posts').then((response) => {
            this.messages = response.data
        })
        api.get('/members').then((response) => {
            this.allUsers = response.data
        })
        api.get('/channels').then((response) => {
            this.channels = response.data
        })
        api.get('/members/' + this.user._id + '/signedin').then((response) => {
            this.user = response.data
        })
        setInterval(function () {
            api.get('/channels/' + this.$route.params.id + '/posts').then((response) => {
                this.messages = response.data
            })
        }.bind(this), 5000);
    },
    methods: {
      home() {
          this.$router.push({name: "home"})
      },
      getUser(u) {
        for(let i = 0; i<this.allUsers.length; i++) {
            if(u == this.allUsers[i]._id) {
                return this.allUsers[i].fullname + ': '
            } 
        }
      },
      editChannel() {
        return api.put('/channels/' + this.$route.params.id, this.channel).then(response => {
            api.get('/channels/' + this.$route.params.id).then((response) => {
                this.created = true
                this.channelInfo = response.data
                this.channel.label = ''
                this.channel.topic = ''
                api.get('/channels').then((response) => {
                    this.channels = response.data
                })
            })
            setInterval(function () {
                    this.created = false
                }.bind(this), 3000); 
            }).catch(error => {
                this.error = true
                setInterval(function () {
                    this.error = false
                }.bind(this), 3000); 
        })
      },
      del() {
          api.delete('/channels/' + this.$route.params.id).then(response => {
                this.$router.push({name: "home"})
            }).catch(error => {
            console.log("error deleting account")
          })
      },
      addChannelPost(event) {
        api.post('/channels/' + this.$route.params.id + '/posts', this.message).then(response => {
            api.get('/channels/' + this.$route.params.id + '/posts').then((response) => {
              this.messages = response.data
              this.message.message = ''
            })
        }).catch(error => {
            console.log("store > channels > addpost -> error")
          }
        )
        event.preventDefault()
        event.stopPropagation()
      },
      deleteMessage(id) {
          api.delete('/channels/' + this.$route.params.id + '/posts/' + id).then(response => {
                api.get('/channels/' + this.$route.params.id + '/posts').then((response) => {
                    this.messages = response.data
                })
            }).catch(error => {
            console.log("error deleting message")
          })
      },
      editMessage(id) {
          this.editMode.id = id
      },
      cancelEdit(id) {
          this.editMode.id = ''
          this.editMode.value = false
      },
      saveMessage(id) {
          this.editMode.value = false
          api.put('/channels/' + this.$route.params.id + '/posts/' + id, this.editMsg).then(response => {
                api.get('/channels/' + this.$route.params.id + '/posts').then((response) => {
                    this.messages = response.data
                    this.editMode.id = ''
                    this.editMsg.message = ''
                })
            }).catch(error => {
            console.log("error editing message")
          })
        },
        signout() {
            this.$store.dispatch('auth/logout', this.user).then(response => {
                this.$router.push({name: "signin"})
            })
        },  
        profile () {
            this.$router.push({name: "profile"})
        },
        users() {
            this.$router.push({name: "users"})
        },
        getChannel(c) {
            this.$router.push({name: "channel", params : { id : c}})
        },
        handleClick(tab, event) {
            console.log(tab, event);
        }
    }
  }
</script>

<style>
    #chat>.el-form-item {
        border: 1px solid rgb(128, 128, 128);
        border-radius: 3px;
        padding: 5px 5px 5px 5px;
    }
</style>