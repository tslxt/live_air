import { setAuthorization } from "./general";
import cookies from 'js-cookie';

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/verifysms', credentials)
            .then((response) => {
                setAuthorization(response.data.token);
                res(response.data);
            })
            .catch((err) =>{
                rej("登录失败");
            })
    })
}

export function sendSms(credentials) {
    return new Promise((res, rej) => {
        axios.post('/laravel-sms/verify-code', credentials)
            .then((response) => {
                res(response.data);
            })
            .catch((err) =>{
                rej("短信验证失败");
            })
    })
}

export function updateUserInfo(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/user_update', credentials)
            .then((response) => {
                res(response.data);
            })
            .catch((err) =>{
                rej("更新失败");
            })
    })
}

export function getLocalUser() {
    const userStr = cookies.get("user");

    if(!userStr) {
        return null
    }

    return JSON.parse(userStr);
}