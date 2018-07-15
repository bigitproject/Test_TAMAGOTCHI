<html>
<head>

    <title>Prob</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<section class="main-slogan">
    <div class="container .justify-content-center">
        <h1>
            TAMAGOTCHI
        </h1>
    </div>
</section>



<section class="new-game">
    <div class="container">

        <div class="row">
            <div class="col-sm-4 ml-auto mr-auto"></div>

            <div class="col-sm-6 ml-auto mr-auto">
                <h2>
                    Новая игра
                </h2>
                <form class="form-inline" id="createform">
                    {{ csrf_field() }}
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="dog">
                        <label class="form-check-label" for="inlineCheckbox1">Собака</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="2" name="cat">
                        <label class="form-check-label" for="inlineCheckbox2">Кот</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="3" name="raccoon">
                        <label class="form-check-label" for="inlineCheckbox3">Енот</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="4" name="penguin">
                        <label class="form-check-label" for="inlineCheckbox3">Пингвин</label>
                    </div>
                    <button type="button" class="new-game btn btn-primary mb-2">Подтвердить</button>
                </form>
            </div>
        </div>
    </div>
</section> <!--end section new-game-->

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                    <h3 class="greet">
                        Привет, user!!! Вот твои питомцы.
                    </h3>
            </div>


            <div class="animal-row clearfix">
                <div class="col-12 animallist">

                    <div class="animal" data-idanimal="1">

                        <div class="row">
                            <div class="col-2">
                                <div class="animal-img">
                                  <img src="img/1.jpg" class="rounded-circle" alt="...">
                                </div>
                            </div>
                            <div class="col-2">
                                <p  class="title hunger-title">
                                    ГОЛОД
                                </p>
                                <p  class="title total" data-idhungeranimal="1">
                                    100
                                </p>
                                <button class="btn btn-primary mb-2 hunger" data-idanimal="1">Накормить</button>
                            </div>

                            <div class="col-2">
                                <p  class="title hunger-title">
                                    СОН
                                </p>
                                <p  class="title total" data-idsleepanimal="1">
                                    100
                                </p>
                                <button class="btn btn-primary mb-2 sleep" data-idanimal="1">Приспать</button>
                            </div>
                            <div class="col-2">
                                <p  class="title hunger-title">
                                    ЗАБОТА
                                </p>
                                <p  class="title total" data-idcareanimal="1">
                                    100
                                </p>
                                <button class="btn btn-primary mb-2 care" data-idanimal="1">Позаботиться</button>
                            </div>
                            <div class="col-2">
                                <p  class="title hunger-title">
                                    ВЕСЕЛЬЕ
                                </p>
                                <p  class="title total">
                                    :)))
                                </p>
                                <button class="btn btn-primary mb-2 joy" data-idanimal="1">Повеселить</button>
                            </div>

                        </div>

                    </div>


                    <div class="animal" data-idanimal="2">

                        <div class="row">
                            <div class="col-2">
                                <div class="animal-img">
                                    <img src="/img/3.jpg" class="rounded-circle" alt="...">
                                </div>
                            </div>
                            <div class="col-2">
                                <p  class="title hunger-title">
                                    ГОЛОД
                                </p>
                                <p  class="title total" data-idhungeranimal="2">
                                    100
                                </p>
                                <button class="btn btn-primary mb-2 hunger" data-idanimal="2">Накормить</button>
                            </div>

                            <div class="col-2">
                                <p  class="title hunger-title">
                                    СОН
                                </p>
                                <p  class="title total" data-idsleepanimal="2">
                                    100
                                </p>
                                <button class="btn btn-primary mb-2 sleep" data-idanimal="2">Приспать</button>
                            </div>
                            <div class="col-2">
                                <p  class="title hunger-title">
                                    ЗАБОТА
                                </p>
                                <p  class="title total" data-idcareanimal="2">
                                    100
                                </p>
                                <button class="btn btn-primary mb-2 care" data-idanimal="2">Позаботиться</button>
                            </div>
                            <div class="col-2">
                                <p  class="title hunger-title">
                                    ВЕСЕЛЬЕ
                                </p>
                                <p  class="title total">
                                    :)))
                                </p>
                                <button class="btn btn-primary mb-2 joy" data-idanimal="2">Повеселить</button>
                            </div>

                        </div>



                    </div>
                </div>

            </div>

        </div>
    </div>
</section> <!--end section content-->


HELLO!!!!!

<button id="spu">Send push</button>

<script src="js/app.js"></script>
<script src="js/script.js"></script>
<script>


        $( "#spu" ).off('click').on('click', function() {
            $.get( "/push", function( data ) {});
        });


        console.log('init pusher#############');
        Echo.channel('App.User.{{auth()->user()->id}}').listen('PublicChat', function(e) {

            console.log('App.User.{{auth()->user()->id}}');
            console.log(e);
            console.log(e.message);

            if(e.status == "update_hunger"){
                update_hunger(e.message);
            }else if(e.status == "update_sleep"){
                update_sleep(e.message);
            }else if(e.status == "update_care"){
                update_care(e.message);
            }else if(e.status == "dunger"){
                dunger(e.message);
            }else if(e.status == "cancel_dunger"){
                cancel_dunger(e.message);
            }else if(e.status == "game_over"){
                game_over(e.message);
            }else if(e.status == "cancel_block_hunger"){
                cancel_block_hunger(e.message);
            }else if(e.status == "cancel_block_sleep"){
                cancel_block_sleep(e.message);
            }else if(e.status == "cancel_block_care"){
                cancel_block_care(e.message);
            }else if(e.status == "cancel_block_joy"){
                cancel_block_joy(e.message);
            }

        });


        function update_hunger(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'p.title.total[data-idhungeranimal="' +id + '"]';

                if(item['hunger_count'] < 5){
                    $(element_search).css('color','#FF0000').html(item['hunger_count']);
                }
                else{
                    $(element_search).css('color','#000000').html(item['hunger_count']);
                }
            });
        }

        function update_sleep(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'p.title.total[data-idsleepanimal="' +id + '"]';

                if(item['sleep_count'] < 5){
                    $(element_search).css('color','#FF0000').html(item['sleep_count']);
                }
                else{
                    $(element_search).css('color','#000000').html(item['sleep_count']);
                }
            });
        }

        function update_care(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'p.title.total[data-idcareanimal="' +id + '"]';

                if(item['care_count'] < 1){
                    $(element_search).css('color','#FF0000').html(item['care_count']);
                }
                else{
                    $(element_search).css('color','#000000').html(item['care_count']);
                }
            });
        }

        function dunger(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'div.animal[data-idanimal="' +id + '"]';
                $(element_search).css('border','3px solid #d919c5');
                //вывести всплывающее сообщение об угрозе смерти животного
            });
        }

        function cancel_dunger(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'div.animal[data-idanimal="' +id + '"]';
                $(element_search).css('border','1px solid #c0c0c0');
                //вывести всплывающее сообщение об отмене угрозы смерти животного
            });
        }

        function game_over(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'div.animal[data-idanimal="' +id + '"]';
                $(element_search).css('background-color','#d919c5');

            });
            //вывести всплывающее сообщение об окончании игры и смерти животных
            alert('К сожалению Вы проиграли! У Вас погиб питомец(цы)');
            $('button.btn.btn-primary.mb-2').attr('disabled', true);
            $('#createform .new-game').attr('disabled', false);
        }

        function cancel_block_hunger(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'button.btn.btn-primary.mb-2.hunger[data-idanimal="' +id + '"]';
                $(element_search).attr('disabled', false);
            });
        }

        function cancel_block_sleep(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'button.btn.btn-primary.mb-2.sleep[data-idanimal="' +id + '"]';
                $(element_search).attr('disabled', false);
            });
        }

        function cancel_block_care(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'button.btn.btn-primary.mb-2.care[data-idanimal="' +id + '"]';
                $(element_search).attr('disabled', false);
            });
        }

        function cancel_block_joy(animals){
            animals.forEach((item, i, arr)=> {
                let id = item['animal_type_id'];
                let element_search = 'button.btn.btn-primary.mb-2.joy[data-idanimal="' +id + '"]';
                $(element_search).attr('disabled', false);
            });
        }



</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"> </script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>