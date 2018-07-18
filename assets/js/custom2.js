          $(window).load(function(){      
   $('#myModal').modal('show');
   setTimeout(function(){$('#myModal').modal('hide')},2200);
    }); 
              $("#alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert").slideUp(500);
            });
                $('.confirmation').on('click', function () {
                    return confirm('دڵنیای لە ئەنجامدانی ئەم کردارە؟');
                });
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
            $(function() {
  $("input[type='file'].filepicker").filepicker();
});
            $('#input').on('input',function(e){
               $('#check').prop('checked', true);
            });
            $(function(){
              var hash = window.location.hash;
              hash && $('ul.nav1 a[href="' + hash + '"]').tab('show');

              $('.nav-tabs a').click(function (e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
              });
            });
      $('#time').dateTimePicker({
    mode: 'dateTime',
    format: 'yyyy/MM/dd HH:mm:ss'
  });
    $('#t2').dateTimePicker({
    mode: 'dateTime',
    format: 'yyyy/MM/dd HH:mm:ss'
  });
  
  $('#date').dateTimePicker();
  $('#date1').dateTimePicker();

          $('#date2').dateTimePicker({
            limitMax: $('#date3')
        });

        $('#date3').dateTimePicker({
            limitMin: $('#date2')
        });

$('#snotic').dateTimePicker();
$('#enotic').dateTimePicker({
  limitMin: $('#snotic')
});
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

function sweet(v1,v2,v3,v4){
    swal({
    type: v1,
    title: v2,
    text: v3,
    confirmButtonText: 'باشە',
    timer: v4,
  })
}

$(document).ready(function(){
    $('#save').submit(function(){
        // $('#response').html("<b>Loading response...</b>");
        $.ajax({
            type: 'POST',
            url: 'save.php', 
            data: $(this).serialize(),
        })
        .done(function(data){
            sweet('success','سوپاس','زانیاریەکان بەسەرکەوتویی نوێکرانەوە.','2000')
        })
        .fail(function() {
            sweet('error','ببورە','کێشەیەک ڕویدا نەتوانرا زانیاریەکان نوێبکرێنەوە.','2000')
        });
        return false;
    });
});




 var htm = $("#timetable").html();
  $('#addtm').click(function() {
      $(htm).fadeIn("slow").appendTo('#timetable').html();
      $('.selectpicker').selectpicker('refresh');
          $('html, body').animate({
            scrollTop: $("#addtm").offset().top - 300
          }, 1000);
  }); 

var i=0;
var i2=1;
  $('#addquestion').click(function() {
  var htm2 = '<hr style="width:100%;margin:10px 0px 10px"><div class="form-group"> <label>پرسیاری ('+i2+')</label><textarea required="" rows="6" class="form-control" name="qu[]"></textarea></div><div class="form-group"> <label>نمرە</label> <input required="" name="mark[]" type="number" class="form-control"></div><div id="ans"><div class="col-md-6"><div class="form-group input-group"> <span class="input-group-addon"> <input checked value="1" name="anser['+ i +']" class="an" type="radio"> </span> <input required="" name="a1[]" placeholder="وەڵامی یەکەم" type="text" class="form-control"></div></div><div class="col-md-6"><div class="form-group input-group"> <span class="input-group-addon"> <input value="2" name="anser['+ i +']" class="an" type="radio"> </span> <input required="" name="a2[]" placeholder="وەڵامی دووەم" type="text" class="form-control"></div></div><div class="col-md-6"><div class="form-group input-group"> <span class="input-group-addon"> <input value="3" name="anser['+ i +']" class="an" type="radio"> </span> <input required="" name="a3[]" placeholder="وەڵامی سێیەم" type="text" class="form-control"></div></div><div class="col-md-6"><div class="form-group input-group"> <span class="input-group-addon"> <input value="4" name="anser['+ i +']" class="an" type="radio"> </span> <input required="" name="a4[]" placeholder="وەڵامی چوارەم" type="text" class="form-control"></div></div></div>';
      
      $(htm2).fadeIn("slow").appendTo('#question').html();
      $('.selectpicker').selectpicker('refresh');
      i++;
      i2++;
          $('html, body').animate({
            scrollTop: $("#addquestion").offset().top - 300
          }, 1000);
          
  });  

  $('#addquestion2').click(function() {
  var htm2 = '<hr style="width:100%;margin:10px 0px 10px"><div class="form-group"> <label>پرسیاری ('+i2+')</label><textarea required="" rows="6" class="form-control" name="qu[]"></textarea></div><div class="form-group"> <label>نمرە</label> <input required="" name="mark[]" type="number" class="form-control"></div>';

      $(htm2).fadeIn("slow").appendTo('#question').html();
      $('.selectpicker').selectpicker('refresh');
            i2++;
          $('html, body').animate({
            scrollTop: $("#addquestion").offset().top - 300
          }, 1000);
          
  });
  
  
  // $('#qg option').eq(1).prop('selected',true);
  // $('#qg').change(function() {
  //   if (i==0 ) {
  //     $('#addquestion').click();
  //    }
  // });

  $('.user').keyup(function() {

    var user1    = $(this).val();
    if(user == ""){          
    }
    else{

$.post('post.php', {user: user1}, function(data) {
  if(data=='1'){
     $('.help-block').css('display', 'block');
     $('.user').css({
       'border-color': '#a94442',
     });
  }else{
      $('.help-block').css('display', 'none');
     $('.user').css({
       'border-color': 'green',
     });
  }
});

}


  });
