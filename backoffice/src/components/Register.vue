<template>
    <el-row :gutter="20">
        <el-col :span="12" :offset="6">
            <h1>Create new account</h1>
            <el-form>
                <el-form-item label="Full name*">
                    <el-input @keyup.enter.native="newuser" v-model="createuser.fullname" id="fullname" clearable></el-input>
                </el-form-item>
                <el-form-item label="Email*">
                    <el-input @keyup.enter.native="newuser" v-model="createuser.email" id="email" clearable></el-input>
                </el-form-item>
                <el-form-item label="Password*">
                    <el-input @keyup.enter.native="newuser" v-model="createuser.password" id="password" type="password" clearable></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="newuser">Register</el-button>
                </el-form-item>
            </el-form>
            <el-alert v-if="created" title="Account created" type="success" center></el-alert>
            <el-alert v-if="error" title="Please verify your information" type="error" center></el-alert>

            <p>Already have an account? <router-link :to="{name: 'signin', path: '/signin'}" exact><a>Signin</a></router-link> </p>

        </el-col>
    </el-row>
</template>

<script>
import api from '../api'
export default {
  data () {
    return {
      createuser: {fullname: '', email: '', password:''},
      created: false,
      error: false
    }
  },
  methods: {
      newuser() {
        api.post('/members', this.createuser).then(response => {
                this.created = true
                this.createuser = {fullname: '', email: '', password:''}
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
  }
}
</script>