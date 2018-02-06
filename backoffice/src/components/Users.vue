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
            <el-table :data="allUsers" style="text-align: left">
              <el-table-column prop="_id" label="ID"> 
              </el-table-column>
              <el-table-column prop="fullname" label="Name"> 
              </el-table-column>
              <el-table-column prop="email" label="Email"> 
              </el-table-column>
            </el-table>
          </el-main>
        </el-container>
      </el-col>

    </el-row>
</template>

<script>

import api from '../api'
export default {
  name: 'Users',
  data () {
    return {
      allUsers: [{}],
      channels: {},
      user: {}
    }
  },
  created () {
    api.get('/members').then((response) => {
      this.allUsers = response.data
    })
    api.get('/channels').then((response) => {
      this.channels = response.data
    })
    api.get('/members/' + this.user._id + '/signedin').then((response) => {
      this.user = response.data
    })
  },
  methods: {
    home() {
        this.$router.push({name: "home"})
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
