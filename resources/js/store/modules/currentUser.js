const state = {
    user : {
        // email : "ehsan@gmail.com"
    },
};
const getter = {};
const actions = {
    getUser( {commit} ){
        axios.get("/api/user/current")
            .then ( response => {
                commit('setUser', response.data );
            });
    },
    registerUser( {}, user ) {
        axios.post("/api/user/register", {
            name : user.name ,
            email : user.email ,
            password : user.password
        })
    },
    loginUser( {}, user ) {
        axios.post("/api/user/login", {
            email : user.email ,
            password : user.password
        })
            .then ( response => {
                console.log(response.data)
                if (response.data.access_token){
                    //save token
                    localStorage.setItem(
                        "blog_token",
                        response.data.access_token
                    )
                    window.location.replace("/home");
                }
            })
    },
    logoutUser(){
        //remove token
        localStorage.removeItem("blog_token");
        window.location.replace("/login");

    }

};
const mutations = {
    setUser( state, data ){
        state.user = data;
    }
};

export default {
    namespaced : true,
    state,
    getter,
    actions,
    mutations
}
