import { setAuthorization } from "@/js/helpers/general";

export function login(credentials) {
    return new Promise((res, rej) => {
        axios.post('/api/auth/login', credentials)
             .then((response) => {
                 if(response.data.status == 401) {
                    rej('Wrong password or Email');
                 } else {
                     setAuthorization(response.data.access_token);
                     res(response.data);
                 }
             })
    })
}

export function getLocalUser() {
    const userStr = localStorage.getItem("user");

    if(!userStr) {
        return null;
    }

    return JSON.parse(userStr);
}