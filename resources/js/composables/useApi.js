import axios from "axios";

const api = axios.create({
    baseURL: "/api",
    withCredentials: true,
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
    },
});

function applyBearerTokenFromLocalStorage() {
    const token = localStorage.getItem("token");

    if (token) {
        api.defaults.headers.common.Authorization = `Bearer ${token}`;
        return;
    }

    delete api.defaults.headers.common.Authorization;
}

export function useApi() {
    applyBearerTokenFromLocalStorage();
    return api;
}
