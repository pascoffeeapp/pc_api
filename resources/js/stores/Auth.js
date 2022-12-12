import { defineStore } from "pinia";
import axios from 'axios';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000/api/";
export const AuthStore = defineStore('auth', {
    state: () => ({
        // authenticated: false,
        // token: "",
    }),
    actions: {
        getToken() {
            return window.localStorage.getItem('_token');
        },
        isAuthenticated() {
            let _token = window.localStorage.getItem('_token');
            return (_token) ? true : false;
        },
        login(params, success, error) {
            axios.post('/auth/login', params)
            .then((res) => {
                let _token = res.data.body.token;
                window.localStorage.setItem('_token', _token)
                success(_token);
                axios.interceptors.request.use((config) => {
                    config.headers['Authorization'] = `Bearer ${ _token }`;
                    return config;
                })
            }).catch((err) => {
                error(err)
            })
        },
        logout(success, error) {
            // if (this.isAuthenticated()) {
            //     axios.interceptors.request.use((config) => {
            //         config.headers['Authorization'] = `Bearer ${ _token }`;
            //         return config;
            //     })
            // }
            axios.post('/auth/logout')
            .then((res) => {
                window.localStorage.removeItem('_token');
                success(res);
            }).catch((err) => {
                error(err)
            })
        }
    },
})