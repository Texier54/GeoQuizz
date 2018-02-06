<template>
    <el-row :gutter="20">
      <el-col :span="8">
        <el-aside width="200px">
          <el-menu :default-openeds="['1']">
            <el-submenu index="1">
              <template slot="title"><i class="el-icon-menu"></i>Channels</template>
              <el-menu-item-group>
                    <el-menu-item 
                      v-for="channel in channels" 
                      @click="getChannel(channel._id)" 
                      v-bind:data="channel" 
                      v-bind:key="channel._id"
                      index="1">
                        {{ channel.label }}
                      </el-menu-item>
              </el-menu-item-group>
            </el-submenu>
          </el-menu>
        </el-aside>
      </el-col>

      <el-col :span="10">
        <el-container>

          <el-header style="text-align: right; font-size: 12px">
            <span>Welcome {{user.fullname}} </span>
            <el-dropdown>
              <i class="el-icon-setting" style="margin-right: 15px"></i>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item @click.native="users()">List users</el-dropdown-item>
                <el-dropdown-item @click.native="profile()">Profile</el-dropdown-item>
                <el-dropdown-item @click.native="signout()">Logout</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </el-header>

          <el-main>
            <el-form>
              <h1>Create Channel </h1>
              <el-form-item label="Label*">
                  <el-input @keyup.enter.native="newChannel" v-model="channel.label" id="label" clearable></el-input>
              </el-form-item>
              <el-form-item label="Topic">
                  <el-input @keyup.enter.native="newChannel" v-model="channel.topic" id="topic" clearable></el-input>
              </el-form-item>
              <el-form-item>
                  <el-button type="primary" @click="newChannel">Add</el-button>
              </el-form-item>
            </el-form>
          </el-main>
          <el-alert v-if="created" title="Channel created" type="success" center></el-alert>
          <el-alert v-if="error" title="No label duplicates allowed." type="error" center></el-alert>
        </el-container>
      </el-col>

    </el-row>
</template>

<script>
  import api from '../api'

  export default {
    name: 'Home',
    data() {
      return {
        channel: {label: '', topic: ''},
        channels: {},
        user: {},
        created: false,
        error: false
      }
    },
    created() {
      api.get('/channels').then((response) => {
        this.channels = response.data
      })
      api.get('/members/' + this.user._id + '/signedin').then((response) => {
        this.user = response.data
      })
    },
    methods: {
      signout() {
        this.$store.dispatch('auth/logout', this.user).then(response => {
          this.$router.push({name: "signin"})
        })
      },
      newChannel() {
        return api.post('/channels', this.channel).then(response => {
          this.channels.push(response.data)
          this.channel.label = ''
          this.channel.topic = ''
          this.created = true
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
      profile () {
        this.$router.push({name: "profile"})
      },
      users() {
        this.$router.push({name: "users"})
      },
      getChannel(c) {
        this.$router.push({name: "channel", params : { id : c}})
      }
    }
  }
</script>
