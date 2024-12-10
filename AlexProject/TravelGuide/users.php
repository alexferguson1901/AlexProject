<!DOCTYPE html>
<html lang="en">
<head>

    <title>Reviews Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #005f73;
        }
        .form-group {
            margin: 20px 0;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #005f73;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .review {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .review h4 {
            margin: 0;
            color: #333;
        }
        .review p {
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
<center><h1> Create User </h1>
<img src="BaliIndonesia.jpg" width="500px">
    <form id="bali_userForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Create User"><br></center>
        </div>
    </form>

    <div id="_response"></div>

    <script>
        $(document).ready(function() {
            $('#bali_userForm').on('submit', function(event) {
                event.preventDefault(); 

                $.ajax({
                    type: 'POST',
                    url: 'createUser.php', 
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#bali_response').html(response); 
                    },
                    error: function(xhr, status, error) {
                        $('#bali_response').html('Error: ' + error); 
                    }
                });
            });
        });
    </script>
</body>
</html>
