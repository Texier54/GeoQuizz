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
            <el-form>
                <el-form-item label="ID">
                    <el-input disabled :value="user._id"></el-input>
                </el-form-item>
                <el-form-item label="Name">
                    <el-input disabled :value="user.fullname"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input disabled :value="user.email"></el-input>
                </el-form-item>
            </el-form>
            <div style="text-align: right">
              <el-button type="danger" @click="del()" round>Delete account</el-button>
            </div>
          </el-main>
        </el-container>
      </el-col>

    </el-row>

</template>

<script>

import api from '../api'
export default {
  name: 'Profile',
  data () {
    return {
      channels: {},
      user: [{}]
    }
  },
  created () {
    api.get('/members/' + this.user._id + '/signedin').then((response) => {
      this.user = response.data
    })
    api.get('/channels').then((response) => {
      this.channels = response.data
    })
  },
  methods: {
      home() {
          this.$router.push({name: "home"})
      },
      del() {
          api.delete('/members/' + this.user._id).then(response => {
                this.$store.dispatch('auth/delete', this.user).then(response => {
                    this.$router.push({name: "signin"})
                })
            }).catch(error => {
            console.log("error deleting account")
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
      }
  }
}
</script>
