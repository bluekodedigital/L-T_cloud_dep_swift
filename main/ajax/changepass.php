<div class="col-md-12" style="margin-top: 15px; ">
      <div class="col-md-9" style="margin-bottom: 5px; ">
            <div class="form-group">
                  <label class="control-form col-md-5" style="color: #010910;  float: left;margin-top: 5px;" for="m-pass">Old Password</label>
                  <div style="padding: 0;" class="col-md-6">
                        <input class="form-control" type="password" name="o-pass" id="o-pass" placeholder="Old Password">
                  </div>
            </div>
      </div>
      <div class="col-md-9" style="margin-bottom: 5px; ">
            <div class="form-group">
                  <label class="control-form col-md-5" style="color: #010910;  float: left;margin-top: 5px;" for="m-pass">New Password</label>
                  <div style="padding: 0;" class="col-md-6">
                        <input class="form-control" type="password" name="n-pass" id="n-pass" placeholder="New Password">
                  </div>
            </div>
      </div>
      <div class="col-md-9" style="margin-bottom: 5px; ">
            <div class="form-group">
                  <label class="control-form col-md-5" style="color: #010910;  float: left;margin-top: 5px;" for="m-pass">Confirm Password</label>
                  <div style="padding: 0;" class="col-md-6">
                        <input class="form-control" type="password" name="c-pass" id="c-pass" placeholder="New Password">
                  </div>
            </div>
      </div>
      <div class="col-md-9">
            <div class="form-group">
                  <div class="col-md-9">
                        <input type="button" name="submit" id="pc-submit" class="btn btn-success" value="Save">
                  </div>
            </div>
      </div>
      <div class="col-md-3">
            <input type="button" name="hd-div" id="hd-div" class="btn btn-info" value="Back">
      </div>
</div>
<script type="text/javascript">
      $("#pc-submit").on("click", function(){
                  var opass = $("#o-pass").val();
                  var npass = $("#n-pass").val();
                  var cpass = $("#c-pass").val();

                  //alert(opass); exit();
                  if(npass == cpass){
                        var req = $.ajax({
                              type : "post",
                              url  : "ajax/checkpass.php",
                              data : { pass : opass }
                        });
                        req.done(function(data){
                              if(data == 1){
                                    var newreq = $.ajax({
                                          type : "post",
                                          url  : "ajax/editpass.php",
                                          data : { opass : opass, npass : npass, cpass : cpass }
                                    });
                                    newreq.done(function(msg){
                                          if(msg == 1){
                                                document.getElementById('o-pass').value="";
                                                document.getElementById('n-pass').value="";
                                                document.getElementById('c-pass').value="";
                                                document.getElementById('mod4-cont').innerHTML=""
                                                alert("Password changed Succesfully...");
                                          }
                                          else{
                                                alert("Sorry... Try again...");
                                          }
                                    });
                              }
                              else{
                                    alert("Old password is Wrong....");
                              }
                        });
                  }
                  else{
                        alert("Confirm password and New password not matched..!");
                  }
            });

      $("#hd-div").click(function(){
            document.getElementById('mod4-cont').innerHTML="";
      });
</script>