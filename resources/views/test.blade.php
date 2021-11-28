<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropme@latest/dist/cropme.css">
</head>
<body>
    <h1>Crop Me</h1>
    <!-- <input type="file" class="custom-file-input" id="backCoverFile" required> -->
    <img src="blob:http://localhost:8000/8b7a9adc-0ecf-48e6-9d1b-1b2b04491235" id="myImage"/>


<script src="{{asset('/js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/cropme@latest/dist/cropme.js"></script>

<script>
  $('#myImage').cropme();
</script>

</body>
</html>