<?php
if (!isset($das)) {
  header('HTTP/1.0 403 Forbidden');
   exit; 
}
?>
    </div>
             <!-- /. PAGE INNER  -->
   </div>
  <script src="assets/js/jquery.typeahead.min.js" ></script>
  <script src="assets/js/date-time-picker.min.js"></script>
  <script src="assets/js/jquery.filepicker.js"></script>
  <script src="assets/js/modernizr.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/bootstrap-notify.min.js"></script>                                            
  <script src="assets/js/custom2.js"></script>
  <script src="assets/js/ajax.js"></script>
  <script src="assets/js/jquery.metisMenu.js"></script>
  <script src="assets/js/bootstrap-toggle.min.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="assets/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="assets/js/dataTables.buttons.min.js"></script>
  <script src="assets/js/pdfmake.min.js"></script>
  <script src="assets/js/buttons.html5.min.js"></script>
  <script src="assets/js/buttons.print.min.js"></script>
  <script src="assets/js/jszip.min.js"></script>
  <script src="assets/js/buttons.flash.min.js"></script>

<script>

$('#send').click(function(event) {
  if ($('#reply').val().trim()=="") {
    sweet('error','هەڵە!','تکایە خانەکە بەبەتاڵی بەجێ مەهێڵە.','2000');
    return false;
  }
});

$('#chat-box').animate({scrollTop:99999}, '0');

$(".req").attr("data-toggle", "tooltip").attr("data-title", "پێویستە ئەم خانەیە بەدروستی پڕبکەیەوە").after('<label class="req2"> * </label>')
$(".req2").attr("data-toggle", "tooltip").attr("data-title", "پێویستە ئەم خانەیە بەدروستی پڕبکەیەوە").css('color', '#f27474');

$(".req2").next().attr('required', 'true');


$("#report_student").change(function() {
  if ($(this).val()=="location") {
    $('#gender').css('display', 'none');
    $('#bl').css('display', 'none');
    $('#location').fadeIn().css('display', 'block');

  }else if ($(this).val()=="gender") {
    $('#location').css('display', 'none');
    $('#bl').css('display', 'none');
    $('#gender').fadeIn().css('display', 'block');
  }else if ($(this).val()=="bl") {
    $('#location').css('display', 'none');
    $('#gender').css('display', 'none');
    $('#bl').fadeIn().css('display', 'block');
  }
});

  $(function () {
    $('#advance').DataTable({
      <?php if(!isset($_GET['view']) AND !isset($_GET['edit'])){ ?>
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      <?php }else{ ?>
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      <?php } ?>
    //  "paginate": {
    //   "previous": "Previous page"
    // },

      "language": {
                "search": "<span>گەڕان:</span> _INPUT_",
                  "lengthMenu": "_MENU_ زانیاری لە هەر پەڕەیەک",
                  "zeroRecords": "ببورە هیچ زانیاریەک نەدۆزرایەوە",
                  "info": "لاپەڕە _PAGE_ لە _PAGES_",
                  "infoEmpty": "ببورە هیچ زانیاریەک نەدۆزرایەوە",
                  "infoFiltered": "(ئەنجامی گەڕان لەکۆی _MAX_)",
                  "paginate": {
                      'next': 'دواتر', // or '→'
                      'previous': 'پێشتر', // or '←' 
                    }
              },
        dom: 'Bfrtip',
        buttons: [
            // 'copy', 'csv', 'excel', 'print'

            {
                extend: 'print',
                filename: 'downloaded',
                title: '',

                text: '<i class="fa fa-print"></i>'
                <?php if(!isset($_GET['date']) AND !isset($_GET['view'])){ ?>,
                exportOptions: {
                  columns: ':not(:last-child)',
                }
                <?php } ?>
            },
            {
                extend: 'copyHtml5',
                filename: 'downloaded',
                title: '',
                text: '<i class="fa fa-files-o"></i>'<?php if(!isset($_GET['date'])){ ?>,
                exportOptions: {
                  columns: ':not(:last-child)',
                }
                <?php } ?>
            },            
            {
                extend: 'excelHtml5',
                filename: 'excel',
                text: '<img class="export" src="assets/img/file-excel.svg"/>',
                title: ''<?php if(!isset($_GET['date'])){ ?>,
                exportOptions: {
                  columns: ':not(:last-child)',
                }
                <?php } ?>
             }//,
            // {
            //     extend: 'csvHtml5',
            //     filename: 'csv',
            //     title: ''<?php if(!isset($_GET['date'])){ ?>,
            //     exportOptions: {
            //       columns: ':not(:last-child)',
            //     }
            //     <?php } ?>
            // }
        ]
            // dom: 'lBfrtip',
            // buttons: [
            //     'copyHtml5',
            //     'excelHtml5',
            //     'csvHtml5',
            //     'pdfHtml5'
            // ]

    })

  });
  $(function () {
    $('#advance2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "language": {
                "search": "<span>گەڕان:</span> _INPUT_",
                  "lengthMenu": "_MENU_ زانیاری لە هەر پەڕەیەک",
                  "zeroRecords": "ببورە هیچ زانیاریەک نەدۆزرایەوە",
                  "info": "لاپەڕە _PAGE_ لە _PAGES_",
                  "infoEmpty": "ببورە هیچ زانیاریەک نەدۆزرایەوە",
                  "infoFiltered": "(ئەنجامی گەڕان لەکۆی _MAX_)",
                  "paginate": {
                      'next': 'دواتر', // or '→'
                      'previous': 'پێشتر', // or '←' 
                    }
              },
        dom: 'Blfrtip',
        buttons: [

            {
                extend: 'print',
                filename: 'downloaded',
                title: '',

                text: '<i class="fa fa-print"></i>'
                
            },
            {
                extend: 'copyHtml5',
                filename: 'downloaded',
                title: '',
                text: '<i class="fa fa-files-o"></i>'
            },            
            {
                extend: 'excelHtml5',
                filename: 'excel',
                text: '<img class="export" src="assets/img/file-excel.svg"/>',
                title: ''
             }
        ]


    })

  });

function noti(type,top,left,text){
  $.notifyDefaults({
                type: type,
                allow_dismiss: false,
                placement: {
                  from: top,
                  align: left
                }
              });
    $.notify(text);
}

setTimeout( function() {
  $('.dt-buttons .buttons-copy').click(function() {
  noti('success','top','left','سەپاس بەسەرکەوتویی کۆپی کرا.');
});  
  $('.dt-buttons .buttons-excel').click(function() {
  noti('success','top','left','سەپاس بەسەرکەوتویی داگیرا بە جۆری ئێگزڵ(Excel).');
});

}, 100)


<?php if (home=="qg.php?id") { ?>
  $.typeahead({
      input: '.qg',
      minLength: 0,
      order: "desc",
      source: {
          data: [
              "نیوەی سەرەتای وەرزی یەکەم","نیوەی کۆتایی وەرزی یەکەم","کۆتایی وەرزی یەکەم","سەرەتای وەرزی یەکەم",
              "نیوەی سەرەتای خولی یەکەم","نیوەی کۆتایی خولی یەکەم","کۆتایی خولی یەکەم","سەرەتای خولی یەکەم"
          ]
      },
      callback: {
          onInit: function (node) {
              console.log('Typeahead Initiated on ' + node.selector);
          }
      }
  });
      // vriable is set and isnt falsish so it can be used;

<?php } ?>

  $.typeahead({
      input: '#loc',
      minLength: 0,
      hint: true,
      accent: true,
      searchOnFocus: true,
      order: "asc",
      source: {
          data: ["هەولێر","سلێمانی","فارسی","ئامێدی","بارزان","ئاکرێ","عەنکاوە","سمیل","کۆیە","چەمچەماڵ","ڕەواندز","هەڵەبجە","شەقڵاوە","زاخۆ","رانیە","دهۆک","کەرکوک"]
      },
      callback: {
          onInit: function (node) {
              console.log('Typeahead Initiated on ' + node.selector);
          }
      }
  });
  
</script>
</body>
</html>
