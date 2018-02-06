<template>
    <el-row :gutter="20">
        <el-col :span="12" :offset="6">
            <h1>Welcome back!</h1>
            <el-form>
                <el-form-item label="Email">
                    <el-input @keyup.enter.native="signin" v-model="user.email" id="email" clearable></el-input>
                </el-form-item>
                <el-form-item label="Password">
                    <el-input @keyup.enter.native="signin" v-model="user.password" id="password" type="password" clearable></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="signin" value="submit">Login</el-button>
                </el-form-item>
            </el-form>
            <p>Need an account? <router-link :to="{name: 'register', path: '/register'}" exact><a>Register</a></router-link> </p>
        </el-col>
    </el-row>
</template>

<script>
import api from '../api'
export default {
  data () {
    return {
      user: {email: '', password:''}

    }
  },
  methods: {
      signin() {
          this.$store.dispatch('auth/login', this.user).then(response => {
              this.$router.push({name: "home"})
          })
      }
  }
}
</script>