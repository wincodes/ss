</div>
</div>
 <footer class="panel-footer">
 <div class="container-fluid">
    <div class="bottom-footer"> 

      <div class="col-sm-5 col-md-5">
          <ul class="list-inline">
          <li><a href="about.php">About us</a></li>
          <li><a href="contact.php">Contact us</a></li>
          <li><a href="terms.php"> Terms of use</a></li>
          <li><a href="privacy.php"> Privacy Policy</a></li> 
        </ul>
      </div>
      <div class="col-sm-7 col-md-7">
           Copyright &copy;2016-2017 The Sport Social Network (sportsocia.com)
      </div>

    </div>
</div>
 </footer>
  <script   src="http://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript" src="script.js"></script>
</body>
</html>
  <?php
  if (isset($dbc)) {
  mysqli_close($dbc);
}

  ?>