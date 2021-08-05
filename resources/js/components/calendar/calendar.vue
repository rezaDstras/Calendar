<template>
    <v-row class="fill-height">
        <v-col>
            <v-sheet height="64">
                <v-toolbar
                    flat
                >
                    <v-btn
                        class="mr-4"
                        color="primary"
                        dark
                        @click="dialog=true"
                    >
                        New Event
                        <v-icon
                            dark
                            right
                        >
                            mdi-lead-pencil
                        </v-icon>
                    </v-btn>
                    <v-btn
                        outlined
                        class="mr-4"
                        color="grey darken-2"
                        @click="setToday"
                    >
                        Today
                    </v-btn>
                    <v-btn
                        fab
                        text
                        small
                        color="grey darken-2"
                        @click="prev"
                    >
                        <v-icon small>
                            mdi-chevron-left
                        </v-icon>
                    </v-btn>
                    <v-btn
                        fab
                        text
                        small
                        color="grey darken-2"
                        @click="next"
                    >
                        <v-icon small>
                            mdi-chevron-right
                        </v-icon>
                    </v-btn>
                    <v-toolbar-title v-if="$refs.calendar">
                        {{ $refs.calendar.title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-menu
                        bottom
                        right
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                outlined
                                color="grey darken-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                <span>{{ typeToLabel[type] }}</span>
                                <v-icon right>
                                    mdi-menu-down
                                </v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item @click="type = 'day'">
                                <v-list-item-title>Day</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = 'week'">
                                <v-list-item-title>Week</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = 'month'">
                                <v-list-item-title>Month</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = '4day'">
                                <v-list-item-title>4 days</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-toolbar>
            </v-sheet>
            <!-- Add Event Dialog-->
            <v-dialog v-model="dialog" max-width="500">
                <v-card>
                    <v-container>
                        <v-form @submit.prevent="addEvent">
                            <v-text-field
                                v-model="name"
                                type="text"
                                label="Event Name (required)">
                            </v-text-field>
                            <v-text-field
                                v-model="details"
                                type="text"
                                label="Event Detail (required)">
                            </v-text-field>
                            <v-text-field
                                v-model="start"
                                type="date"
                                label="Start Date (required)">
                            </v-text-field>
                            <v-text-field
                                v-model="end"
                                type="date"
                                label="End Date (required)">
                            </v-text-field>
<!--                            <v-text-field-->
<!--                                v-model="color"-->
<!--                                type="color"-->
<!--                                label="Color (Click To Open Color Selector)">-->
<!--                            </v-text-field>-->
                            <v-btn
                                type="submit"
                                color="primary"
                                class="mr-4"
                                @click.stop="dialog=false"
                            >
                                Create Event

                            </v-btn>
                        </v-form>
                    </v-container>
                </v-card>
            </v-dialog>

            <v-sheet height="600">
                <v-calendar
                    ref="calendar"
                    v-model="focus"
                    color="primary"
                    :events="events"
                    :event-color="getEventColor"
                    :type="type"
                    @click:event="showEvent"
                    @click:more="viewDay"
                    @click:date="viewDay"
                    @change="updateRange"
                ></v-calendar>
                <v-menu
                    v-model="selectedOpen"
                    :close-on-content-click="false"
                    :activator="selectedElement"
                    offset-x
                >
                    <v-card
                        color="grey lighten-4"
                        min-width="350px"
                        flat
                    >
                        <v-toolbar
                            :color="selectedEvent.color"
                             dark
                        >
<!--                            <v-btn icon>-->
<!--                                <v-icon>mdi-pencil</v-icon>-->
<!--                            </v-btn>-->
                            <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn
                                v-if="selectedEvent.status == 1"
                                color="success"
                                dark
                                >
                                Accept
                                <v-icon
                                    dark
                                    right
                                >
                                    mdi-checkbox-marked-circle
                                </v-icon>
                            </v-btn>
                            <v-btn
                                v-else-if="selectedEvent.status == null"
                                color="yellow darken-2"
                                dark
                            >
                                Waiting
                                <v-icon
                                    dark
                                    right
                                >
                                    mdi-alert-circle-outline
                                </v-icon>
                            </v-btn>
                            <v-btn
                                v-else
                                color="red"
                                dark
                            >
                                Rejected
                                <v-icon
                                    dark
                                    right
                                >
                                    mdi-cancel
                                </v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <h5>Requested By : {{user.name}}</h5>
                            <br>
                            <v-spacer></v-spacer>
                            <span v-html="selectedEvent.details"></span>

                        </v-card-text>
                        <v-card-actions>
                            <v-btn
                                text
                                color="info"
                                @click="selectedOpen = false"
                            >
                                Cancel
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-menu>
            </v-sheet>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        data: () => ({
            today: new Date().toISOString().substr(0, 10),
            focus: new Date().toISOString().substr(0, 10),
            type: 'month',
            typeToLabel: {
                month: 'Month',
                week: 'Week',
                day: 'Day',
                '4day': '4 Days',
            },
            user:{
                id:null,
                name:null
            },
            name:null,
            details:null,
            start:null,
            end:null,
            color:"orange",
            currentlyEditing:null,
            selectedEvent: {},
            selectedElement: null,
            selectedOpen: false,
            events: [],
            dialog: false,
        }),
        mounted () {
            this.getEvents();
        },
        methods: {
             async getEvents(){
                await axios.get('http://127.0.0.1:8000/api/event')
                    .then(res  =>{
                        this.events = res.data
                    })
            },
            async addEvent(){
                if (this.name && this.start && this.end){
                    await axios.post('http://127.0.0.1:8000/api/event',{
                        name:this.name,
                        details:this.details,
                        start:this.start,
                        end:this.end,
                        color:this.color
                    });
                    this.$toaster.success('Your Event Has Been Created Successfully', {timeout: 8000})
                    this.getEvents();
                    this.name='';
                    this.details='';
                    this.start='';
                    this.end='';
                    this.color='';
                }else{
                    alert('uncomplited');
                }
            },
            viewDay ({ date }) {
                this.focus = date
                this.type = 'day'
            },
            getEventColor (event) {
                return event.color
            },
            setToday () {
                this.focus = ''
            },
            prev () {
                this.getEvents();
                this.$refs.calendar.prev()
            },
            next () {
                this.getEvents();
                this.$refs.calendar.next()
            },
            showEvent ({ nativeEvent, event }) {
                const open = () => {
                    this.selectedEvent = event
                    this.user = event.user
                    this.selectedElement = nativeEvent.target
                    requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
                }

                if (this.selectedOpen) {
                    this.selectedOpen = false
                    requestAnimationFrame(() => requestAnimationFrame(() => open()))
                } else {
                    open()
                }

                nativeEvent.stopPropagation()
            },
            updateRange ({ start, end }) {
                const events = []

                const min = new Date(`${start.date}T00:00:00`)
                const max = new Date(`${end.date}T23:59:59`)
                const days = (max.getTime() - min.getTime()) / 86400000
                const eventCount = this.rnd(days, days + 20)

                for (let i = 0; i < eventCount; i++) {
                    const allDay = this.rnd(0, 3) === 0
                    const firstTimestamp = this.rnd(min.getTime(), max.getTime())
                    const first = new Date(firstTimestamp - (firstTimestamp % 900000))
                    const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
                    const second = new Date(first.getTime() + secondTimestamp)

                    events.push({
                        name: this.names[this.rnd(0, this.names.length - 1)],
                        start: first,
                        end: second,
                        color: this.colors[this.rnd(0, this.colors.length - 1)],
                        timed: !allDay,
                    })
                }

                this.events = events
            },
            rnd (a, b) {
                return Math.floor((b - a + 1) * Math.random()) + a
            },
        }

    }
</script>

<style scoped>

</style>
