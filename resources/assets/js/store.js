import { getLocalUser } from "./helpers/auth";
import cookies from 'js-cookie';

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.token});

            cookies.set("user", JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            cookies.remove("user");
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        updateUserLocal(state, payload) {
            state.currentUser = Object.assign(state.currentUser, payload);
        },
        updateUserRemote(state, payload) {
            state.currentUser = Object.assign(state.currentUser, payload);
            cookies.set("user", JSON.stringify(state.currentUser));
        },
    },
    actions: {
        login(context) {
            context.commit("login");
        },
    }
};