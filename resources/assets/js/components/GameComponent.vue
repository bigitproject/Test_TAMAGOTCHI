<template>
    <div class="container">
        <div class="main-slogan">
            <div class="container .justify-content-center">
                <h1>
                    TAMAGOTCHI
                </h1>
            </div>
        </div>


        <div class="new-game">
            <div class="row">
                <div class="col-sm-4 ml-auto mr-auto">
                </div>

                <div class="col-sm-6 ml-auto mr-auto">
                    <h2>
                        Новая игра
                    </h2>

                    <form class="form-inline" id="createform"  >

                        <template v-for="item in animalsForNewGame">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" v-bind:value="item" v-model="selectedAnimals">
                                <label class="form-check-label">{{item.name}}</label><br>
                            </div>
                        </template>
                        <button type="button" class="new-game btn btn-primary mb-2" v-on:click="createNewGame()">Подтвердить</button>
                    </form>

                </div>
            </div>
        </div> <!--end section new-game-->


        <ul>
            <template v-for="(item, index) in animals">
                <div class="animal" v-bind:style="{'background-color': item.background_color, border: item.border}">

                    <div class="row">
                        <div class="col-12 col-sm-3 cell">
                            <div class="animal-img">
                                <img v-bind:src="'img/' +item.animal_type_id + '.jpg'" class="rounded-circle" alt="...">
                            </div>
                        </div>
                        <div class="col-12 col-sm-2  cell">
                            <p  class="title hunger-title">
                                ГОЛОД
                            </p>
                            <p  class="title total" v-bind:style="{color: item.hunger_color}">
                                {{item.hunger_count}}
                            </p>
                            <button class="btn btn-primary mb-2 hunger" v-on:click="updateСharacteristic('/hungr', index)" :disabled="item.hunger_button_disabled"> Накормить</button>

                        </div>

                        <div class="col-12 col-sm-2  cell">
                            <p  class="title hunger-title">
                                СОН
                            </p>
                            <p  class="title total" v-bind:style="{color: item.sleep_color}">
                                {{item.sleep_count}}
                            </p>
                            <button class="btn btn-primary mb-2 sleep" v-on:click="updateСharacteristic('/sleep', index)" :disabled="item.sleep_button_disabled">Приспать</button>
                        </div>
                        <div class="col-12 col-sm-2  cell">
                            <p  class="title hunger-title">
                                ЗАБОТА
                            </p>
                            <p  class="title total" v-bind:style="{color: item.care_color}">
                                {{item.care_count}}
                            </p>
                            <button class="btn btn-primary mb-2 care" v-on:click="updateСharacteristic('/care', index)" :disabled="item.care_button_disabled">Позаботиться</button>
                        </div>
                        <div class="col-12 col-sm-2 cell">
                            <p  class="title hunger-title">
                                ВЕСЕЛЬЕ
                            </p>
                            <p  class="title total">
                                :)))
                            </p>
                            <button class="btn btn-primary mb-2 joy" v-on:click="updateСharacteristic('/joy', index)" :disabled="item.joy_button_disabled">Повеселить</button>
                        </div>

                    </div>

                </div>
            </template>
        </ul>

    </div>
</template>




<script>



    export default {
        name: "GameComponent",


        data: function(){
            return {
                test: false,
                animalsForNewGame: [
                    {dbname:'dog', name:'Собака', id: 1},
                    {dbname:'cat', name:'Кот', id: 2},
                    {dbname:'raccoon', name:'Енот', id: 3},
                    {dbname:'penguin', name:'Пингвин', id: 4},
                ],
                selectedAnimals: [],
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                user: 0,
                animals: []

            }
        },


        mounted() {
            console.log('Component GAME mounted.');
        },

        methods: {

            startEcho(){
                let vue_obj = this;

                console.log('init pusher#############');
                      window.Echo.channel('App.User.' + vue_obj.user).listen('PublicChat', function(e) {

                            console.log('App.User.' + vue_obj.user);
                            console.log(e);
                            console.log(e.message);

                            switch(e.status)
                            {
                                  case "update_hunger": vue_obj.sysUpdateHunger(e.message);  break;
                                  case "update_sleep": vue_obj.sysUpdateSleep(e.message);  break;
                                  case "update_care": vue_obj.sysUpdateCare(e.message);  break;
                                  case "dunger": vue_obj.sysDunger(e.message);  break;
                                  case "cancel_dunger": vue_obj.sysCancelDunger(e.message);  break;
                                  case "game_over": vue_obj.sysGameOver(e.message);  break;
                                  case "cancel_block_hunger": vue_obj.sysCancelBlockHunger(e.message);  break;
                                  case "cancel_block_sleep": vue_obj.sysCancelBlockSleep(e.message);  break;
                                  case "cancel_block_care": vue_obj.sysCancelBlockCare(e.message);  break;
                                  case "cancel_block_joy": vue_obj.sysCancelBlockJoy(e.message);  break;
                            }
                      });

                console.log('init pusher#############');

            },

            createNewGame() {

                if(this.selectedAnimals.length < 1) {
                     alert('Выберите животных для новой игры!');
                     return;
                }

                this.animals = [];

                let request = {};
                this.selectedAnimals.forEach(c=>{request[c.dbname]=c.id});
                console.log(request);
                let vue_obj = this;

                axios.post('/newgame', request)
                    .then(function (response) {

                        console.log(response);
                        console.log("OK axios - " + response.data);
                        let data = response.data;
                        if(data.success){
                            vue_obj.user = data.user_id;
                            console.log("Animals getted " + data.animals.length);
                            vue_obj.printAnimals(data.animals);
                            vue_obj.startEcho();
                            vue_obj.selectedAnimals = [];
                        }
                    })
                    .catch(function (error) {
                        console.log("Error (on server) - " + error);
                    });

            },

            printAnimals(list){
                console.log("HELLO" + list[0].hunger_count);
                for (let i = 0, len = list.length; i < len; i++) {
                    this.animals.push({
                        animal_type_id: list[i].animal_type_id,
                        hunger_count: list[i].hunger_count,
                        sleep_count: list[i].sleep_count,
                        care_count: list[i].care_count,
                        hunger_color: 'black',
                        hunger_button_disabled: false,
                        sleep_color: 'black',
                        sleep_button_disabled: false,
                        care_color: 'black',
                        care_button_disabled: false,
                        joy_button_disabled: false,
                        border: '1px solid #c0c0c0',
                        background_color: 'white',
                    });
                }
            },

            updateСharacteristic(URL, index){
                let vue_obj = this;

                axios.post(URL, {'id': vue_obj.animals[index].animal_type_id} )
                    .then(function (response) {
                        console.log(response);
                        console.log("OK axios - " + response.data);
                        let data = response.data;

                        if(data.success){
                            switch(URL)
                            {
                                case '/hungr':
                                    vue_obj.changeHunger(data.animal, index);
                                    break;
                                case '/sleep':
                                    vue_obj.changeSleep(data.animal, index);
                                    break;
                                case '/care':
                                    vue_obj.changeCare(data.animal, index);
                                    break;
                                case '/joy':
                                    vue_obj.changeJoy(data.animal, index);
                                    break;
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log("Error (on server) - " + error);
                    });
            },

            changeHunger(data, index){
                console.log("+ Animals hunger + " + data.hunger_count);
                this.animals[index].hunger_count = data.hunger_count;
                this.animals[index].hunger_button_disabled = true;
                if(data.hunger_count < 5){
                    this.animals[index].hunger_color = 'red';
                }else{
                    this.animals[index].hunger_color = 'black';
                    this.animals[index].border= '1px solid #c0c0c0';
                }
            },

            changeSleep(data, index){
                console.log("+ Animals sleep + " + data.sleep_count);
                this.animals[index].sleep_count = data.sleep_count;
                this.animals[index].sleep_button_disabled = true;
                if(data.sleep_count < 5){
                    this.animals[index].sleep_color = 'red';
                }else{
                    this.animals[index].sleep_color = 'black';
                }
            },

            changeCare(data, index){
                console.log("+ Animals care + " + data.care_count);
                this.animals[index].care_count = data.care_count;
                this.animals[index].care_button_disabled = true;
                if(data.care_count < 1){
                    this.animals[index].care_color = 'red';
                }else{
                    this.animals[index].care_color = 'black';
                }
            },

            changeJoy(data, index){
                console.log("+ Animals joy + ");
                this.animals[index].joy_button_disabled = true;
                alert("AX AX AX! Как мне весело! ");
            },

            testPusher(){
                console.log("Test - " + this.test);
                if(!this.test)   return;

                axios.get('/push')
                    .then(function (response) {
                        console.log("OK!!!");
                    })
                    .catch(function (error) {
                        console.log("Error - " + error);
                    });
            },

            findIndexAnimalById(id){
                 let index = -1;
                 for(let i=0, len=this.animals.length; i < len; i++) {
                    if(this.animals[i].animal_type_id == id){
                        index = i; break;
                    }
                 }
                 return index;
            },

            sysUpdateHunger(list){
                console.log("SYS update hunger------------");
                for (let i = 0, len = list.length; i < len; i++) {
                     console.log("animal hunger = " + list[i].hunger_count);

                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;

                     this.animals[aIndex].hunger_count=list[i].hunger_count;
                     if(this.animals[aIndex].hunger_count < 5){
                           this.animals[aIndex].hunger_color = 'red';
                     }else{
                           this.animals[aIndex].hunger_color = 'black';
                     }
                }
            },

            sysUpdateSleep(list){
                console.log("SYS update sleep------------");
                for (let i = 0, len = list.length; i < len; i++) {
                     console.log("animal sleep = " + list[i].sleep_count);

                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;

                     this.animals[aIndex].sleep_count=list[i].sleep_count;
                     if(this.animals[aIndex].sleep_count < 5){
                           this.animals[aIndex].sleep_color = 'red';
                     }else{
                           this.animals[aIndex].sleep_color = 'black';
                     }
                }
            },

            sysUpdateCare(list){
                console.log("SYS update care------------");
                for (let i = 0, len = list.length; i < len; i++) {
                     console.log("animal care = " + list[i].care_count);

                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;

                     this.animals[aIndex].care_count=list[i].care_count;
                     if(this.animals[aIndex].care_count < 1){
                           this.animals[aIndex].care_color = 'red';
                     }else{
                           this.animals[aIndex].care_color = 'black';
                     }
                }
            },

            sysDunger(list){
                console.log("SYS dunger");
                for (let i = 0, len = list.length; i < len; i++) {
                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;
                     this.animals[aIndex].border= '3px solid #d919c5';
                     this.animals[aIndex].hunger_count=list[i].hunger_count;
                }
                alert("Животные в опасности!");
            },

            sysCancelDunger(list){
                console.log("SYS cancel dunger");
                for (let i = 0, len = list.length; i < len; i++) {
                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;
                     this.animals[aIndex].border= '1px solid #c0c0c0';
                     this.animals[aIndex].hunger_count=list[i].hunger_count;
                }
            },

            sysGameOver(list){
                for (let i = 0, len = list.length; i < len; i++) {
                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;
                     this.animals[aIndex].background_color= '#d919c5';
                }
                for (let i = 0, len = this.animals.length; i < len; i++) {
                     this.animals[i].hunger_button_disabled = true;
                     this.animals[i].sleep_button_disabled = true;
                     this.animals[i].care_button_disabled = true;
                     this.animals[i].joy_button_disabled = true;
                }
                alert('К сожалению Вы проиграли! У Вас погиб питомец(цы)');
                this.delAnimals();
            },

            delAnimals(){
                axios.post('/del')
                    .then(function (response) {
                        console.log("OK!!!");
                    })
                    .catch(function (error) {
                        console.log("Error - " + error);
                    });
            },

            sysCancelBlockHunger(list){
                for (let i = 0, len = list.length; i < len; i++) {
                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;
                     this.animals[aIndex].hunger_button_disabled = false;
                }
            },

            sysCancelBlockSleep(list){
                for (let i = 0, len = list.length; i < len; i++) {
                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;
                     this.animals[aIndex].sleep_button_disabled = false;
                }
            },

            sysCancelBlockCare(list){
                for (let i = 0, len = list.length; i < len; i++) {
                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;
                     this.animals[aIndex].care_button_disabled = false;
                }
            },

            sysCancelBlockJoy(list){
                for (let i = 0, len = list.length; i < len; i++) {
                     let aIndex = this.findIndexAnimalById(list[i].animal_type_id);
                     if(aIndex < 0) continue;
                     this.animals[aIndex].joy_button_disabled = false;
                }
            },


        }
    }
</script>
