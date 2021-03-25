<?php
include_once('glava.php');
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link href="meme.css" rel="stylesheet">

  <title>Meme Library</title>

</head>

<body>
  <br>
  <main role="main">
    <div class="album py-5 bg-light">
      <div class="container">
        <div class="row">

          <?php
          $results_per_page = 12;
          $query = "SELECT id, title, description, image, IDfk from memes ORDER BY id DESC";

          $res = mysqli_query($conn, $query);
          $number_of_results = mysqli_num_rows($res); //število vrstic v tabeli memes

          $number_of_pages = ceil($number_of_results / $results_per_page);

          $page = (int)$_GET['page'];
          if (!isset(($page))) { 
            $page = 1;
          } else {
            $page = (int)$_GET['page'];
          }

          $this_page_first_result =mysqli_real_escape_string($conn,($page - 1) * $results_per_page);
          $results_per_page = mysqli_real_escape_string($conn, $results_per_page);
          
          $query = "SELECT id, title, description, image, IDfk FROM memes ORDER BY id DESC LIMIT " . $this_page_first_result . ',' . $results_per_page;
          $res = mysqli_query($conn, $query);

          while ($row = mysqli_fetch_array($res)) {
          ?>
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <?php echo "<img class='card-img-top' width='300' height='300' src='" . $row['image'] . "' />";
                ?>
                <div class="card-body">
                  <b class="card-text"><?php echo $row['title']; ?></b>
                  <p class="card-text"><?php echo $row['description']; ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.href='/ogled.php?id=<?php echo $row['id']; ?>'">Ogled</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php
          }
          ?>
  </main>

  <ul class="pagination justify-content-center">
    <?php
    function get_pagination_links($current_page, $total_pages, $url)
    {
      if ($total_pages == 1) {
      } else {
        $links = "";
        if ($total_pages >= 1 && $current_page <= $total_pages) {
          $links .= "<li class='page-item'><a class='page-link' href=\"{$url}?page=1\">1</a></li>";
          $i = max(2, $current_page - 5);
          if ($i > 2)
            $links .= " ..... ";
          for (; $i < min($current_page + 6, $total_pages); $i++) {
            $links .= "<li class='page-item'><a class='page-link' href=\"{$url}?page={$i}\">{$i}</a></li>";
          }
          if ($i != $total_pages)
            $links .= " ..... ";
          $links .= "<li class='page-item'><a class='page-link' href=\"{$url}?page={$total_pages}\">{$total_pages}</a></li>";
        }
        return $links;
      }
    }

    echo get_pagination_links($_GET['page'], $number_of_pages, "meme.php")
    ?>
  </ul>

  <footer class="text-muted">
    <div class="container">
      <p class="float-left">
        <a>Solve-x</a>
    </div>
  </footer>

</body>

</html>