<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="background-color: black;">

        <nav>
            <div class="bg-secondary">
                &nbsp;
            </div>
        </nav>

        <div class="d-flex">
            <div class="bg-primary d-flex w-50">
                <h1>Profile Page</h1
            </div>

            <div class="d-flex bg-secondary w-50">
                <h1>PROFILE</h1>

                <div class="d-flex flex-row w-100">

                    <div class="form-floating mb-3">
                        <input type="date" name="birthday" required class="form-control" id="floatingInput" placeholder="">
                        <label for="floatingInput">Birthday:</label>
                    </div>

                    <div class="d-flex flex-column mb-3 ms-3">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

            </div>
            
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
</body>
</html>