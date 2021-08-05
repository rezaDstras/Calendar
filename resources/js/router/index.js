import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Dashboard from "../components/dashboard/Container"
import Calendar from "../components/calendar/calendar"
import AdminCalendar from "../components/calendar/AdminCalendar";

const routes = [
    {
        component:Dashboard,
        name:"dashboard",
        path:"/dashboard"
    },
    {
        component:Calendar,
        name:"calendar",
        path:"/calendar"
    },
    {
        component:AdminCalendar,
        name:"adminCalendar",
        path:"/AdminCalendar"
    }
];

export default new VueRouter({
        mode: 'history',
        routes
});

