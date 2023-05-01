<html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <title>Add Policy</title>
</head>
<body>
  <div class="container mt-3">
    <h3 class="text-center">Add Time Off Policy</h3>
    <form action="add_policy_submit.php" method="post">
      <div class="form-group">
        <label for="policy_name">Policy Name</label>
        <input type="text" class="form-control" id="policy_name" name="policy_name" required>
      </div>
      <div class="form-group">
        <label for="policy_description">Policy Description</label>
        <textarea class="form-control" id="policy_description" name="policy_description" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>
</html>