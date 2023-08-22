<?php

require_once "config.php";

if (!isset($_SESSION['admin_id'])) {
  header('location:index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Description of your website">

  <!-- Include Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
</head>

<body class="bg-gray-100">

  <?php if(isset($_SESSION['success_message'])) : ?>
       <div class="bg-green-500 p-4 text-white text-center">
        <p class="text-lg font-semibold"> 
          <?php 
          echo $_SESSION['success_message'];
          unset($_SESSION['success_message']);
        ?>
        </p>
      </div>
      
  <?php endif; ?>


  <div class="container mx-auto">
    <div class="flex flex-col mb-5">
      <div class="md:w-1/2 mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Register Member</h2>
        <form action="register_member.php" method="POST" enctype="multipart/form-data" id="registrationForm">
          <label class="block mb-2">First Name:</label>
          <input class="w-full border rounded px-3 py-2 mb-2" type="text" name="first_name">
          <label class="block mb-2">Last Name:</label>
          <input class="w-full border rounded px-3 py-2 mb-2" type="text" name="last_name">
          <label class="block mb-2">Email:</label>
          <input class="w-full border rounded px-3 py-2 mb-2" type="email" name="email">
          <label class="block mb-2">Phone Number:</label>
          <input class="w-full border rounded px-3 py-2 mb-2" type="text" name="phone_number">
          <label class="block mb-2">Training Plan:</label>
          <select class="w-full border rounded px-3 py-2 mb-2" name="training_plan_id">
            <option value="" disabled selected>Training Plan</option>
            <option value="1">15 session plan</option>
            <option value="2">30 session plan</option>
            <?php
            $sql = "SELECT * FROM training_plans";
            $run = $conn->query($sql);
            $results = $run->fetch_all(MYSQLI_ASSOC);
            foreach ($results as $result) {
              echo "<option value='" . $result['plan_id'] . "'>" . $result->name . "</option>";
            }
            ?>
          </select> <br>
          <div id="dropzone-upload" class="dropzone border border-dashed p-16 mb-2"></div>
          <input type="hidden" name="photo_path" id="photoPathInput">
          <input class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded" type="submit" value="Register Member">
        </form>
      </div>
    </div>
  </div>
<?php $conn->close(); ?>

  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
            <script>

              Dropzone.options.dropzoneUpload = {
                url: "upload_photo.php",
                paramName: "photo",
                MaxFileSize: 20, //MB
                acceptedFiles: "image/*",
                init: function (){
                  this.on("success", function(file, response){
                    // Parse the JSON respone
                    const jsonResponse = JSON.parse(response);
                    //Check if the file was uploaded successfully
                    if (jsonResponse.success) {
                      // Ser the hidden input's value to the uploaded file's path
                      document.getElementById('photoPathInput').value = jsonResponse.photo_path;

                    } else {
                      console.error(jsonResponse.error);
                    }
                  });
                }
              };
            </script>
</body>

</html>