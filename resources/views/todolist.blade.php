<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 5.2 | Simple To do list</title>

        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
            WebFont.load({
                google: {
                    "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
                },
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <link href="{{ env('ASSETS') }}bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid mt-5">
            <div class="card col-md-6">
                <h5 class="card-header text-center">Simple To do List</h5>
                <div class="alert alert-success" id="success" role="alert" style="display: none;"></div>
                <div class="alert alert-danger" id="error" role="alert" style="display: none;"></div>
                <div class="card-body">
                    <div class="input-group mb-3">
                          <input type="text" name="todolist" id="todolist" class="form-control" placeholder="Type your to do list and press Add button" aria-label="todolist" aria-describedby="button-addon2">
                          <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="add-list">Add</button>
                          </div>
                    </div>
                    <ul class="list-group list-group-flush" id="todolistData"></ul>
                </div>
            </div>
        </div>

        <script src="{{ env('ASSETS') }}jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function(){
                todolist()

                $("#add-list").click(() => {
                    $.ajax({
                        url: "/add-todo",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            todolist: $("#todolist").val()
                        },
                        success: function( result ) {
                            if(result.error == 0) {
                                $("#todolist").val('')
                                $("#success").fadeIn();
                                $("#success").text(result.message)
                                todolist()

                                setTimeout(() => {
                                    $("#success").fadeOut();
                                },3000);
                            } else {
                                $("#error").fadeIn();
                                $("#error").text(result.message)
                                setTimeout(() => {
                                    $("#error").fadeOut();
                                },3000);
                            }
                        }
                    });
                })
            })

            function todolist() {
                $.ajax({
                    url: "/todolist",
                    type: "GET",
                    success: function( result ) {
                        if(result.error == 0) {
                            let todolistData = ''

                            result.data.forEach((value) => {
                                todolistData += `<li class="list-group-item">
                                    ${value.list_name}
                                    <button class="btn btn-error" type="button" onclick="deleteList(${value.id})"> X </button>
                                </li>`
                            })

                            $("#todolistData").html(todolistData)
                        } else {
                            console.log(result)
                            return false
                        }
                    }
                });
            }

            function deleteList(id) {
                $.ajax({
                    url: `/delete-todo/${id}`,
                    type: "DELETE",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function( result ) {
                        if(result.error == 0) {
                            $("#todolist").val('')
                            $("#success").fadeIn();
                            $("#success").text(result.message)
                            todolist()

                            setTimeout(() => {
                                $("#success").fadeOut();
                            },3000);
                        } else {
                            $("#error").fadeIn();
                            $("#error").text(result.message)
                            setTimeout(() => {
                                $("#error").fadeOut();
                            },3000);
                        }
                    }
                });
            }
        </script>
    </body>
</html>
