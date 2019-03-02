<template>
    <div class="crud" v-bind:class="id">
        <span class="hidden class-id">{{id}}</span>
        <div class="col-2" :class="{id}">
            <h2>Ticket #{{ id }}</h2>
            <h3>Ticket lines: {{ lines }}</h3>

            <b v-html="parseCheckResult()"></b>

            <button @click="check">Check ticket</button><br/><br/>
            <span class="amend-section">
            <p>Add </p><input class="noLinesToAmmend" type="text" /><p> additional lines to this ticket</p><button @click="update()">Ammend</button><br/><br/>
            </span>
                <button @click="del">Delete</button>
        </div>
    </div>
</template>
<script>
    export default {
        data (){return {noLinesToAmmend: ''}},

        methods: {
            update() {
                let inputValue= $('.crud span:contains("'+this.id+'") + div input').val();

                if(inputValue){
                    this.$emit('update', this.id, inputValue);
                }
            },
            del() {
                this.$emit('delete', this.id);
            },
            check() {
                $('.crud span:contains("'+this.id+'") + div .amend-section').hide();
                this.$emit('check', this.id);
            },
            parseCheckResult() {
                let result = this.value;
                if (result) {
                    let parsedResult = '';
                    if (result['zeroPointLines'].length) {
                        parsedResult += 'The lines with no points were the ones on position : ' + result['zeroPointLines']+'</br>';
                    }
                    if (result['onePointLines'].length) {
                        parsedResult += 'The lines with 1 point : ' + result['onePointLines']+'</br>';
                    }
                    if (result['fivePointLines'].length) {
                        parsedResult += 'The lines with 5 points : ' + result['fivePointLines']+'</br>';
                    }
                    if (result['tenPointLines'].length) {
                        parsedResult += 'The lines with 10 points : ' + result['tenPointLines']+'</br>';
                    }
                    return parsedResult + '\t\tThe total points of the ticket is : ' + result['totalValue']+'</br>';
                }
            }
        },
        props: ['id', 'lines', 'value', 'ticketLineNo'],
    }
</script>
<style>
    .crud {
        display: flex;
        margin: 1em 1em 1em 0;
        border: 1px solid #d1d1d1;
        padding: 1em;
        background-color: white;
    }

    .hidden { display: none}

    .crud img {
        height: 70px;
    }

    .col-2 {
        margin-left: 1em;
    }

    .col-2 > h3 {
        margin: 0.5em 0;
    }

    #app div:last-child p, #app div:last-child button, #app div:last-child input {
        float: left;
        margin: 0 2px;

    }

    #app div:last-child input {
        width: 39px;
    }

    * {
        font-family: Calibri, sans-serif;
    }


</style>
