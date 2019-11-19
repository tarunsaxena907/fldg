$(document).ready(function(){
  var currentDate = new Date();
    var m = currentDate.getMonth(), d = currentDate.getDate(), y = currentDate.getFullYear();
    var defaultyear = y - 25; /* variable added to set default year on showing datepicker*/
    $('.DOB').datepicker({
        /* minDate: new Date(y, m, d+1),*/
        dateFormat: 'yy-mm-dd',
        yearRange: "-65:+0",
        maxDate: "-20y",
        defaultDate: new Date(defaultyear, m, d)
    });

  var dateFormat = "mm/dd/yy",
  from = $( "#fromDate" )
    .datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1
    })
    .on( "change", function() {
      to.datepicker( "option", "minDate", getDate( this ) );
    }),
  to = $( "#toDate" ).datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    numberOfMonths: 1
  })
  .on( "change", function() {
    from.datepicker( "option", "maxDate", getDate( this ) );
  });

function getDate( element ) {
  var date;
  try {
    date = $.datepicker.parseDate( dateFormat, element.value );
  } catch( error ) {
    date = null;
  }
  return date;
}
$('#fromDate + .input-group-append').click(function(){
  $('#fromDate').trigger('focus');
});
$('#toDate + .input-group-append').click(function(){
  $('#toDate').trigger('focus');
});


/* add/remove class 'is-focused' on focus/focusout */
$('.form-control').on('focus',function(){
  $(this).closest('.form-group').addClass('is-focused');
});
$('.form-control').on('focusout',function(){
  $(this).closest('.form-group').removeClass('is-focused');
});

  $('input').not('.fakeinput').on('keyup blur', function (e) {
      $(this).closest('.form-group').removeClass('has-error');
      $(this).removeClass("invalid");
      $(this).removeClass("error");
  });
  $('input[type="checkbox"],input[type="radio"]').on('click', function () {
      $(this).removeClass("error ,invalid");
      $(this).closest('.form-group').removeClass('has-error');
  });

  /*on keypress accept numbers only*/
    $('.Numericonly').on('keypress change', function (e) {
        var key;
        document.all ? key = e.keyCode : key = e.which;
        if (
          /* Allow: backspace, delete, tab, escape, enter*/
          $.inArray(key, [0, 8, 9, 27, 13, 190]) !== -1 ||
          /* Allow: 0 to 9*/
          (key >= 48 && key <= 57)) {
            return;
        }
        else{
          e.preventDefault();
        }
    });


/* edit personal information script*/
$("#personal-info-form").validate({
      ignore: [],
      errorClass: 'is-invalid',
      errorPlacement: function (error, element) {
        var errorText = error.text();
        if(element.closest('.form-group').find('.invalid-feedback').length < 1){
          element.closest('.form-group').append('<span class="invalid-feedback">');
        }
        element.closest('.form-group').addClass('has-error');
        element.closest('.form-group').find('.invalid-feedback').html(errorText);
      },
      highlight: function (element, errorClass) {
          $(element).addClass(errorClass).parent().prev().children("select").addClass(errorClass);
          if ($(element).attr('type') == 'radio' || $(element).attr('type') == 'checkbox') {
              $(element).parent().parent().addClass(errorClass);
          }
          if ($(element).attr('name') == 'accept') {
              $(element).next().next().addClass(errorClass);
          }
      },
      rules: {
          fullName: {
            required: true
          },
          DOB: {
            required: true
          },
          mobile: {
            required: true
          },
          email: {
            required: true
          },
          residence: {
            required: true
          },
          city: {
            required: true
          },
          pincode: {
            required: true
          },
          motherName: {
            required: true
          }
      },
      messages:{
        fullName: {
          required: "Name is required field."
        },
        DOB: {
          required: "Date of birth is a required field."
        },
        mobile: {
          required: "Date of birth is a required field."
        },
        email: {
          required: "Email is a required field."
        },
        residence: {
          required: "Residence is a required field."
        },
        city: {
          required: "City is a required field."
        },
        pincode: {
          required: "Pincode is a required field."
        },
        motherName: {
          required: "Mother name is a required field."
        }
      },
      submitHandler: function (form) {
          form.submit();
      }
  });

  /* edit personal information script*/
  $("#employment-info-form").validate({
        ignore: [],
        errorClass: 'is-invalid',
        errorPlacement: function (error, element) {
          var errorText = error.text();
          if(element.closest('.form-group').find('.invalid-feedback').length < 1){
            element.closest('.form-group').append('<span class="invalid-feedback">');
          }
          element.closest('.form-group').addClass('has-error');
          element.closest('.form-group').find('.invalid-feedback').html(errorText);
        },
        highlight: function (element, errorClass) {
            $(element).addClass(errorClass).parent().prev().children("select").addClass(errorClass);
            if ($(element).attr('type') == 'radio' || $(element).attr('type') == 'checkbox') {
                $(element).parent().parent().addClass(errorClass);
            }
            if ($(element).attr('name') == 'accept') {
                $(element).next().next().addClass(errorClass);
            }
        },
        rules: {
            companyName: {
              required: true
            },
            companyEmailID: {
              required: true
            },
            totalExperience: {
              required: true
            },
            designation: {
              required: true
            },
            monthlyIncome: {
              required: true
            },
            officeAddress: {
              required: true
            },
            city: {
              required: true
            },
            pincode: {
              required: true
            },
            officeLandline: {
              required: true
            }
        },
        messages:{
          companyName: {
            required: "Company name is required field."
          },
          companyEmailID: {
            required: "Company email id is a required field."
          },
          totalExperience: {
            required: "Total experience is a required field."
          },
          designation: {
            required: "Designation is a required field."
          },
          monthlyIncome: {
            required: "Monthly income is a required field."
          },
          officeAddress: {
            required: "Office Address is a required field."
          },
          city: {
            required: "City is a required field."
          },
          pincode: {
            required: "Pincode is a required field."
          },
          officeLandline: {
            required: "Office Landline is a required field."
          }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    /* document upload validation script*/
    $("#doc-upload-form").validate({
          ignore: [],
          errorClass: 'is-invalid',
          errorPlacement: function (error, element) {
            var errorText = error.text();
            if(element.closest('.form-group').find('.invalid-feedback').length < 1){
              element.closest('.form-group').append('<span class="invalid-feedback">');
            }
            element.closest('.form-group').addClass('has-error');
            element.closest('.form-group').find('.invalid-feedback').html(errorText);
          },
          highlight: function (element, errorClass) {
              $(element).addClass(errorClass).parent().prev().children("select").addClass(errorClass);
              if ($(element).attr('type') == 'radio' || $(element).attr('type') == 'checkbox') {
                  $(element).parent().parent().addClass(errorClass);
              }
              if ($(element).attr('name') == 'accept') {
                  $(element).next().next().addClass(errorClass);
              }
          },
          rules: {
              panCardFile: {
                required: true
              },
              passPortFile: {
                required: true
              },
              salarySlipFile: {
                required: true
              },
              bankStatementFile: {
                required: true
              },
              addressProofFile: {
                required: true
              }
          },
          messages:{
            panCardFile: {
              required: "Please upload the required document."
            },
            passPortFile: {
              required: "Please upload the required document."
            },
            salarySlipFile: {
              required: "Please upload the required document."
            },
            bankStatementFile: {
              required: "Please upload the required document."
            },
            addressProofFile: {
              required: "Please upload the required document."
            }
          },
          submitHandler: function (form) {
              form.submit();
          }
      });

      $('.form-control-file').each(function(e){
        $(this).change(function(){
          var fileName = $(this).val();
          $(this).closest('.form-group').find('.form-control-text').val(fileName);
        })
      })


      /* document upload validation script*/
      $.validator.addMethod('interest', function(value, element) {
          return this.optional(element) || /^\d{1,2}(\.\d{1,2})?$/.test(value);
      }, 'Please specify a valid data');
      $("#loan-detail-form").validate({
            ignore: [],
            errorClass: 'is-invalid',
            errorPlacement: function (error, element) {
              var errorText = error.text();
              if(element.closest('.form-group').find('.invalid-feedback').length < 1){
                element.closest('.form-group').append('<span class="invalid-feedback">');
              }
              element.closest('.form-group').addClass('has-error');
              element.closest('.form-group').find('.invalid-feedback').html(errorText);
            },
            highlight: function (element, errorClass) {
                $(element).addClass(errorClass).parent().prev().children("select").addClass(errorClass);
                if ($(element).attr('type') == 'radio' || $(element).attr('type') == 'checkbox') {
                    $(element).parent().parent().addClass(errorClass);
                }
                if ($(element).attr('name') == 'accept') {
                    $(element).next().next().addClass(errorClass);
                }
            },
            rules: {
                loanAmount: {
                  required: true
                },
                EMI: {
                  required: true
                },
                tenure: {
                  required: true
                },
                roi: {
                  required: true,
                  interest: true
                }
            },
            messages:{
              loanAmount: {
                required: "Loan amount is required field."
              },
              EMI: {
                required: "EMI is required field."
              },
              tenure: {
                required: "Tenure is required field."
              },
              roi: {
                required: "ROI is required field."
              }
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

});
/*script to conver input value into indian format */
$('input.inrFormat').on('keypress keyup',function() {
  var input = $(this).val().replaceAll(',', '');
  if (input.length < 1)
    $(this).val('');
  else {
    var val = parseFloat(input);
    var formatted = inrFormat(input);
    if (formatted.indexOf('.') > 0) {
      var split = formatted.split('.');
      formatted = split[0] + '.' + split[1].substring(0, 2);
    }
    $(this).val(formatted);
  }
});

function inrFormat(val) {
  var x = val;
  x = x.toString();
  var afterPoint = '';
  if (x.indexOf('.') > 0)
    afterPoint = x.substring(x.indexOf('.'), x.length);
  x = Math.floor(x);
  x = x.toString();
  var lastThree = x.substring(x.length - 3);
  var otherNumbers = x.substring(0, x.length - 3);
  if (otherNumbers != '')
    lastThree = ',' + lastThree;
  var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
  return res;
}

String.prototype.replaceAll = function(search, replacement) {
var target = this;
return target.replace(new RegExp(search, 'g'), replacement);
};
/*script to conver input value into indian format ends*/

$(window).on('load',function(){
  /*script to conver input value into indian format */
  $('input.inrFormat').each(function() {
    var input = $(this).val().replaceAll(',', '');
    if (input.length < 1)
      $(this).val('');
    else {
      var val = parseFloat(input);
      var formatted = inrFormat(input);
      if (formatted.indexOf('.') > 0) {
        var split = formatted.split('.');
        formatted = split[0] + '.' + split[1].substring(0, 2);
      }
      $(this).val(formatted);
    }
  });
});

/* highchart js */
$(document).ready(function(){
  $('#inflow-chart').highcharts({
      chart:{
                type:'pie',
                height: '350',
                  },
            credits:{enabled: false},
            colors:[
                '#05D9E9', '#FF965C', '#FFCDA1', '#8F8F94', '#FFEFA8', '#FFA8CC', '#CCD1FF'],
            title:{text: null},
      plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    showInLegend: true,
                    dataLabels: {
                        enabled: false,
                        formatter: function() {
                            return this.percentage.toFixed(2) + '%';
                        }
                    },
          /*startAngle: -90,
          endAngle: 90,*/
          center: ['50%', '50%']
                }

            },
            legend: {
                enabled: true,
                layout: 'vertical',
                align: 'right',
                width: 200,
                verticalAlign: 'middle',
                useHTML: true,
                labelFormatter: function() {
                    return '<div style="text-align: left; width:150px;float:left; color:#6d6d6d; font-weight:normal;margin-bottom:10px;"> ' + this.name + ' <strong> ' + this.y + '%</strong></div>';
        }
            },
      series: [{
        name: 'Inflow Distribution',
        colorByPoint: true,
        size: '100%',
        innerSize: '50%',
        data: [
          ['Salary', 60],
          ['Cash Deposit', 10],
          ['Transfer In', 30]
        ]
      }],
      responsive:{
        rules: [{
          condition: {
              maxWidth: 478
          },
          chartOptions: {
              legend: {
                  align: 'center',
                  verticalAlign: 'bottom',
                  layout: 'horizontal'
              },
              yAxis: {
                  labels: {
                      align: 'left',
                      x: 0,
                      y: -5
                  },
                  title: {
                      text: null
                  }
              },
              subtitle: {
                  text: null
              },
              credits: {
                  enabled: false
              }
          }
      }]
      }
    });

  $('#outflow-chart').highcharts({
			chart:{
                type:'pie',
                height: '350',
                  },
            credits:{enabled: false},
            colors:[
                '#314BFF', '#64DCA5', '#9DF6CD','#FF7599','#9DF6CD','#95CEFF','#E4B5A3','#D64B5A'],
            title:{text: null},
			plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    showInLegend: true,
                    dataLabels: {
                        enabled: false,
                        formatter: function() {
                            return this.percentage.toFixed(2) + '%';
                        }
                    },
					/*startAngle: -90,
					endAngle: 90,*/
					center: ['50%', '50%']
                }

            },
            legend: {
                enabled: true,
                layout: 'vertical',
                align: 'right',
                width: 200,
                verticalAlign: 'middle',
                useHTML: true,
                labelFormatter: function() {
                    return '<div style="text-align: left; width:150px;float:left; color:#6d6d6d; font-weight:normal;margin-bottom:10px;"> ' + this.name + ' <strong> ' + this.y + '%</strong></div>';
				}
            },
			series: [{
				name: 'Inflow Distribution',
			  colorByPoint: true,
        size: '100%',
			  innerSize: '50%',
				data: [
					['Cash Withdrawal', 60],
					['EMI Payment', 30],
					['Credit card payment', 10]
				]
			}],
      responsive:{
        rules: [{
          condition: {
              maxWidth: 478
          },
          chartOptions: {
              legend: {
                  align: 'center',
                  verticalAlign: 'bottom',
                  layout: 'horizontal'
              },
              yAxis: {
                  labels: {
                      align: 'left',
                      x: 0,
                      y: -5
                  },
                  title: {
                      text: null
                  }
              },
              subtitle: {
                  text: null
              },
              credits: {
                  enabled: false
              }
          }
      }]
      }
		});

    $('#loan-break-chart').highcharts({
  			chart:{
                  type:'pie',
                  height: '350',
                    },
              credits:{enabled: false},
              colors:[
                  '#64DCA5', '#747FE8', '#9DF6CD','#FF7599','#9DF6CD','#95CEFF','#E4B5A3','#D64B5A'],
              title:{text: null},
  			plotOptions: {
                  pie: {
                      allowPointSelect: true,
                      cursor: 'pointer',
                      showInLegend: true,
                      dataLabels: {
                          enabled: true,
                          formatter: function() {
                              return this.percentage.toFixed(2) + '%';
                          }
                      },
  					/*startAngle: -90,
  					endAngle: 90,*/
  					center: ['50%', '50%']
                  }

              },
              legend: {
                  enabled: true,
                  layout: 'vertical',
                  align: 'right',
                  width: 200,
                  verticalAlign: 'middle',
                  useHTML: true,
                  labelFormatter: function() {
                      return '<div style="text-align: left; width:150px;float:left; color:#6d6d6d; font-weight:normal;margin-bottom:10px; line-height:1.4"> ' + this.name + ' </div>';
  				}
              },
  			series: [{
  				name: 'Inflow Distribution',
  			  colorByPoint: true,
          size: '100%',
  			  innerSize: '50%',
          dataLabels: {
                    distance: 5 // Individual distance (in px)
                },
  				data: [
  					['Principal loan Amount', 77.4],
  					['Total Interest', 22.6]
  				]
  			}],
        responsive:{
          rules: [{
            condition: {
                maxWidth: 478
            },
            chartOptions: {
                legend: {
                    align: 'center',
                    verticalAlign: 'bottom',
                    layout: 'horizontal'
                },
                yAxis: {
                    labels: {
                        align: 'left',
                        x: 0,
                        y: -5
                    },
                    title: {
                        text: null
                    }
                },
                subtitle: {
                    text: null
                },
                credits: {
                    enabled: false
                }
            }
        }]
        }
  		});

      $('.show-toggle').click(function(){ //you can give id or class name here for $('button')
          $(this).text(function(i,old){
              return old=='Show More' ?  'Show Less' : 'Show More';
          });
      });
});
