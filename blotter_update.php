<title>POMSYS | Blotter details update</title>
<?php 
    include 'navbar.php';

    if(isset($_GET['blotter_Id'])) {
    $blotter_Id = $_GET['blotter_Id'];
    $fetch = mysqli_query($conn, "SELECT * FROM blotter WHERE blotter_Id='$blotter_Id'");
    $row = mysqli_fetch_array($fetch);
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>Blotter </h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Blotter details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-body p-3">
                    <form action="process_update.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                      <input type="hidden" class="form-control" name="blotter_Id" value="<?php echo $blotter_Id; ?>">
                      <div class="row">

                        <div class="col-lg-12 mt-1 mb-2">
                          <a class="h5 text-primary"><b>Complainant Information</b></a>
                          <div class="dropdown-divider"></div>
                          <h5>Case No.: <b><?= $row['case_no'] ?></b></h5>
                        </div>
                        <div class="col-lg-4 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>First name</b></span>
                              <input type="text" class="form-control"  placeholder="First name" name="c_firstname" required onkeyup="lettersOnly(this)" value="<?= $row['c_firstname'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                              <span class="text-dark"><b>Middle name</b> (Optional)</span>
                              <input type="text" class="form-control"  placeholder="Middle name" name="c_middlename" value="<?= $row['c_middlename'] ?>">
                          </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Last name</b></span>
                              <input type="text" class="form-control"  placeholder="Last name" name="c_lastname" required onkeyup="lettersOnly(this)" value="<?= $row['c_lastname'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Ext/Suffix</b> (Optional)</span>
                            <input type="text" class="form-control"  placeholder="Ext/Suffix" name="c_suffix" value="<?= $row['c_suffix'] ?>">
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Contact number</b></span>
                              <div class="input-group">
                                <div class="input-group-text">+63</div>
                                <input type="tel" class="form-control" pattern="[7-9]{1}[0-9]{9}" id="contact" name="c_contact" placeholder = "9123456789" required maxlength="10" value="<?= $row['c_contact'] ?>">
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Complete address</b></span>
                              <textarea class="form-control" id="" cols="30" rows="2" placeholder="Complete address" name="c_address" required><?= $row['c_address'] ?></textarea>
                            </div>
                        </div>




                        <div class="col-lg-12 mt-3 mb-2">
                          <a class="h5 text-primary"><b>Incident Details</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Date of the incident</b></span>
                              <input type="date" class="form-control"  placeholder="Family Head Name" name="incidentDate" required value="<?= $row['incidentDate'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Time of the incident</b></span>
                              <input type="time" class="form-control"  placeholder="Family Head Name" name="incidentTime" required value="<?= $row['incidentTime'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Nature of incident</b></span>
                              <input class="form-control" placeholder="Nature of incident (e.g., theft, disturbance, violence)" name="incidentNature" required value="<?= $row['incidentNature'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Complete address</b></span>
                              <textarea class="form-control" id="" cols="30" rows="2" placeholder="Complete address" name="incidentAddress" required><?= $row['incidentAddress'] ?></textarea>
                            </div>
                        </div>
                        


                        <div class="col-lg-12 mt-3 mb-2">
                          <a class="h5 text-primary"><b>Accused/Subject Information:</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-4 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>First name</b></span>
                              <input type="text" class="form-control"  placeholder="First name" name="acc_firstname" required onkeyup="lettersOnly(this)" value="<?= $row['acc_firstname'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                              <span class="text-dark"><b>Middle name</b> (Optional)</span>
                              <input type="text" class="form-control"  placeholder="Middle name" name="acc_middlename" value="<?= $row['acc_middlename'] ?>">
                          </div>
                        </div>
                        <div class="col-lg-3 col col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Last name</b></span>
                              <input type="text" class="form-control"  placeholder="Last name" name="acc_lastname" required onkeyup="lettersOnly(this)" value="<?= $row['acc_lastname'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                          <div class="form-group">
                            <span class="text-dark"><b>Ext/Suffix</b> (Optional)</span>
                            <input type="text" class="form-control"  placeholder="Ext/Suffix" name="acc_suffix" value="<?= $row['acc_suffix'] ?>">
                          </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Contact number</b></span>
                              <div class="input-group">
                                <div class="input-group-text">+63</div>
                                <input type="tel" class="form-control" pattern="[7-9]{1}[0-9]{9}" id="contact" name="acc_contact" placeholder = "9123456789" required maxlength="10" value="<?= $row['acc_contact'] ?>">
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Complete address</b></span>
                              <textarea class="form-control" id="" cols="30" rows="2" placeholder="Complete address" name="acc_address" required><?= $row['acc_address'] ?></textarea>
                            </div>
                        </div>


                        <div class="col-lg-12 mt-3 mb-2">
                          <a class="h5 text-primary"><b>Witness Information</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Name/s of Witnesses</b></span>
                              <input type="text" class="form-control"  placeholder="Name/s of Witnesses" name="witnesses" required value="<?= $row['witnesses'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Contact number</b></span>
                              <div class="input-group">
                                <div class="input-group-text">+63</div>
                                <input type="tel" class="form-control" pattern="[7-9]{1}[0-9]{9}" id="contact" name="witnessesContact" placeholder = "9123456789" maxlength="10" value="<?= $row['witnessesContact'] ?>">
                              </div>
                            </div>
                        </div>


                        <div class="col-lg-12 mt-3 mb-2">
                          <a class="h5 text-primary"><b>Description of the Incident</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Narrative or description of what happened</b></span>
                              <textarea class="form-control" id="" cols="30" rows="2" placeholder="Narrative or description of what happened" name="incidentDescription" required><?= $row['incidentDescription'] ?></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-3 mb-2">
                          <a class="h5 text-primary"><b>Actions Taken</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Actions Taken</b></span>
                              <input type="text" class="form-control"  placeholder="Any initial actions taken by authorities or the Barangay in response to the incident" required name="actionTaken" value="<?= ucwords($row['actionTaken']) ?>">
                            </div>
                        </div>


                        <div class="col-lg-12 mt-3 mb-2">
                          <a class="h5 text-primary"><b>Attach any relevant documents or evidence (Photos)</b></a>
                          <div class="dropdown-divider"></div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-6 col-12">
                            <div class="form-group">
                              <span class="text-dark"><b>Attachments</b></span>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="fileToUpload[]" onchange="getImagePreview(event)" multiple>
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                              </div>
                            </div>
                        </div>
                         <!-- LOAD IMAGE PREVIEW -->
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                            <div class="form-group" id="preview">
                            </div>
                        </div>
                       

                    </div>
                    <!-- END ROW -->
                    <hr>
                    <div class="float-right">
                      <a href="blotter.php" class="btn bg-secondary"><i class="fa-solid fa-ban"></i> Cancel</a>
                      <button type="submit" class="btn bg-primary" name="update_blotter"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                    </div>
                    </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <?php } else { include '404.php'; } ?>
  
  <br>
  <br>
  <br>
  <br>

<?php include 'footer.php';  ?>

<script>

   function getImagePreview(event)
  {
    var image=URL.createObjectURL(event.target.files[0]);
    var imagediv= document.getElementById('preview');
    var newimg=document.createElement('img');
    imagediv.innerHTML='';
    newimg.src=image;
    newimg.width="90";
    newimg.height="90";
    newimg.style['border-radius']="50%";
    newimg.style['display']="block";
    newimg.style['margin-left']="auto";
    newimg.style['margin-right']="auto";
    newimg.style['box-shadow']="rgba(100, 100, 111, 0.2) 0px 7px 29px 0px";
    imagediv.appendChild(newimg);
  }


   function signaturess(event)
  {
    var signatureimage=URL.createObjectURL(event.target.files[0]);
    var signatureimagediv= document.getElementById('qrpreview');
    var signaturenewimg=document.createElement('img');
    signatureimagediv.innerHTML='';
    signaturenewimg.src=signatureimage;
    signaturenewimg.width="90";
    signaturenewimg.height="90";
    signaturenewimg.style['border-radius']="50%";
    signaturenewimg.style['display']="block";
    signaturenewimg.style['margin-left']="auto";
    signaturenewimg.style['margin-right']="auto";
    signaturenewimg.style['box-shadow']="rgba(100, 100, 111, 0.2) 0px 7px 29px 0px";
    signatureimagediv.appendChild(signaturenewimg);
  }

  function lettersOnly(input) {
    var regex = /[^a-z ]/gi;
    input.value = input.value.replace(regex, "");
  }


  function validation() {
    var email = document.getElementById("email").value;
    var pattern =/.+@(gmail)\.com$/;
    // var pattern =/.+@(gmail|yahoo)\.com$/;
    var form = document.getElementById("form");

    if(email.match(pattern)) {
        document.getElementById('text').style.color = 'green';
        document.getElementById('text').innerHTML = '';
        document.getElementById('create_admin').disabled = false;
        document.getElementById('create_admin').style.opacity = (1);
    } 
    else {
        document.getElementById('text').style.color = 'red';
        document.getElementById('text').innerHTML = 'Domain must be @gmail.com';
        document.getElementById('create_admin').disabled = true;
        document.getElementById('create_admin').style.opacity = (0.4);
        
    }
  }


    function formatDate(date){
    var d = new Date(date),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');

    }

    function getAge(dateString){
      var birthdate = new Date().getTime();
      if (typeof dateString === 'undefined' || dateString === null || (String(dateString) === 'NaN')){
      // variable is undefined or null value
      birthdate = new Date().getTime();
      }
      birthdate = new Date(dateString).getTime();
      var now = new Date().getTime();
      // now find the difference between now and the birthdate
      var n = (now - birthdate)/1000;
      if (n < 604800){ // less than a week
      var day_n = Math.floor(n/86400);
      if (typeof day_n === 'undefined' || day_n === null || (String(day_n) === 'NaN')){
      // variable is undefined or null
      return '';
      }else{
      return day_n + ' day' + (day_n > 1 ? 's' : '') + ' old';
      }
      } else if (n < 2629743){ // less than a month
      var week_n = Math.floor(n/604800);
      if (typeof week_n === 'undefined' || week_n === null || (String(week_n) === 'NaN')){
      return '';
      }else{
      return week_n + ' week' + (week_n > 1 ? 's' : '') + ' old';
      }
      } else if (n < 31562417){ // less than 24 months
      var month_n = Math.floor(n/2629743);
      if (typeof month_n === 'undefined' || month_n === null || (String(month_n) === 'NaN')){
      return '';
      }else{
      return month_n + ' month' + (month_n > 1 ? 's' : '') + ' old';
      }
      }else{
      var year_n = Math.floor(n/31556926);
      if (typeof year_n === 'undefined' || year_n === null || (String(year_n) === 'NaN')){
      return year_n = '';
      }else{
      return year_n + ' year' + (year_n > 1 ? 's' : '') + ' old';
      }
      }
    }

    function getAgeVal(pid){
      var birthdate = formatDate(document.getElementById("txtbirthdate").value);
      var count = document.getElementById("txtbirthdate").value.length;
      if (count=='10'){
      var age = getAge(birthdate);
      var str = age;
      var res = str.substring(0, 1);
      if (res =='-' || res =='0'){
      document.getElementById("txtbirthdate").value = "";
      document.getElementById("txtage").value = "";
      document.getElementById("agestatus").value = "";
      $('#txtbirthdate').focus();
      return false;
      }else{
      document.getElementById("txtage").value = age;
      document.getElementById("agestatus").value = age;
      }
      }else{
      document.getElementById("txtage").value = "";
      document.getElementById("agestatus").value = "";
      return false;
      }
    }
</script>