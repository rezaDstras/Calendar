<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            app
        >
            <v-list dense>

                <v-list-item to="/dashboard" link  >
                    <v-list-item-action>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item v-show="currentUser.admin == 0"  to="/calendar" link >
                    <v-list-item-action>
                        <v-icon>mdi-calendar</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title >Calendar</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item v-show="currentUser.admin == 1"  to="/AdminCalendar" link >
                    <v-list-item-action>
                        <v-icon>mdi-calendar</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title >Admin Calendar</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click="logout()">
                    <v-list-item-action>
                        <v-icon>mdi-power</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>LogOut</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            app
            color="indigo"
            dark
        >
        <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-toolbar-title>Welcome {{currentUser.name}}</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <v-container fluid class="fill-height" >

              <router-view></router-view>

        </v-container>
        </v-content>
        <v-footer color="indigo" app>
            <span class="white--text">Developed By Reza Dastras</span>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        data: () => ({ drawer: null }),

        computed:{
            loggedIn:{
                get(){
                    return this.$store.state.currentUser.loggedIn;
                }
            },
            currentUser:{
                get(){
                    return this.$store.state.currentUser.user;

                }
            }
        },
        methods: {
            logout(){
                this.$store.dispatch('currentUser/logoutUser');
            }
        },
        created() {
            if (localStorage.hasOwnProperty("blog_token")){
                axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("blog_token");
                this.$store.dispatch('currentUser/getUser');
            }else{
                window.location.replace("/login");
            }
        }
    }
</script>
