<template>
    <div id="app">
        <div class="heading">
            <h1>Ticket dashboard</h1>
        </div>
        <crud-component
                v-for="(ticket, index) in tickets"
                v-bind="ticket"
                :key="ticket.id"
                :index="index"
                @update="update"
                @delete="del"
                @check="check"
        ></crud-component>
        <div>
            <p>Add ticket with</p><input v-model="ticketLineNo" type="text"/><p>lines.</p>
            <button @click="create()">Request ticket</button>
        </div>
    </div>
</template>

<script>
    function Ticket({id, lines, value}) {
        this.id = id;
        this.lines = lines;
        this.value=value;
    }



    import CrudComponent from './Crud.vue';

    export default {
        data() {
            return {
                tickets: [],
                ticketLineNo: '',
                working: false
            }
        },
        methods: {
            create() {
                this.mute = true;
                window.axios.get(`/api/cruds/create/${this.ticketLineNo}`).then(({data}) => {

                    this.tickets.push(new Ticket(data));
                    this.mute = false;
                });
            },
            read() {
                this.mute = true;
                window.axios.get('/api/cruds').then(({data}) => {

                    data.forEach(ticket => {
                        this.tickets.push(new Ticket(ticket));
                    });
                    this.mute = false;
                });
            },
            update(id, ticketLineNo) {
                this.mute = true;
                window.axios.get(`/api/amend/${id}/${ticketLineNo}`).then(({data}) => {
                    this.tickets.find(ticket => ticket.id === id).lines= data;
                    this.mute = false;
                });
            },

            check(id) {
                this.mute = true;
                window.axios.get(`/api/status/${id}`).then(({data}) => {
                    this.tickets.find(crud => crud.id === id).value= data;
                    this.mute = false;
                });
            },
            del(id) {
                this.mute = true;
                window.axios.delete(`/api/cruds/${id}`).then(() => {
                    let index = this.tickets.findIndex(crud => crud.id === id);
                    this.tickets.splice(index, 1);
                    this.mute = false;
                });
            }
        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
        components: {
            CrudComponent
        },
        created() {
            this.read();
        }
    }
</script>
<style>
    #app {
        margin-left: 1em;
    }

    .heading h1 {
        margin-bottom: 0;
    }

    #app > div:last-child {
        HEIGHT: 200px;
        padding: 10px;
        font-size: 20px;
    }
</style>
