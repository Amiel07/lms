@php
    $courseId = isset($course->id) ? $course->id : null;
@endphp
</body>
<script>
    function notify(title, message, type){
        Swal.fire({
        title: title,
        text: message,
        icon: type
      });
    }


    function alertif(message){
      alertify.success(message); 
    }

    var deleteCourseForms = document.getElementsByClassName('deleteCourseForm');
    Array.from(deleteCourseForms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to delete this course?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    var archiveCourseForms = document.getElementsByClassName('archiveCourseForm');
    Array.from(archiveCourseForms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to archive this course?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });
    var unarchiveCourseForms = document.getElementsByClassName('unarchiveCourseForm');
    Array.from(unarchiveCourseForms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to unarchive this course?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    var deleteModuleForms = document.getElementsByClassName('deleteModuleForm');
    Array.from(deleteModuleForms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to delete this module?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    var deleteMaterialForms = document.getElementsByClassName('deleteMaterialForm');
    Array.from(deleteMaterialForms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to delete this material?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    var deleteAssessmentForms = document.getElementsByClassName('deleteAssessmentForm');
    Array.from(deleteAssessmentForms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to delete this quiz?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    var removeEnrolleeForms = document.getElementsByClassName('removeEnrolleeForm');
    Array.from(removeEnrolleeForms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to remove this student from this course?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    var giveAllPointsForm = document.getElementsByClassName('giveAllPointsForm');
    Array.from(giveAllPointsForm).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to give all enrolled students points?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });
    var giveEnrolleeForm = document.getElementsByClassName('giveEnrolleeForm');
    Array.from(giveEnrolleeForm).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to give this student points?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    var submitAssessment = document.getElementsByClassName('submitAssessment');
    Array.from(submitAssessment).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            // Display a confirmation dialog
            event.preventDefault();
            alertify.confirm(
              "Confirmation",
              "Are you sure you want to submit your answers?",
              function(){
                form.submit();
              },
              function(){
                alertify.error("Canceled.");
              }
            );
        });
    });

    $(document).ready(function() {
        $('.powerup-btn').click(function() {
            var courseId = {!! json_encode($courseId) !!};
            var action = $(this).data('action');
            var assessment_id = $(this).data('target');
            var item_num = $(this).data('item');
            var cost = 0;
            switch (action){
              case 'sendhelp':
                cost = 4;
                break;
              case '50-50':
              cost = 3;
                break;
              case '1by1':
              cost = 2;
                break;
            }


            if (alertify.confirm(
              "Confirmation",
              "Are you sure you want to use '" + action + "'? This will cost " + cost + " points. Please note that you can only use a total of 9 points for this quiz.",
              function(){
                if (action === 'sendhelp'){
                  $.ajax({
                    type: 'POST',
                    url: '{{route("assessment.SendHelp")}}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        action: action,
                        data: {
                          course_id: courseId,
                          assessment_id: assessment_id,
                        }
                    },
                    success: function(response) {
                        if (!response.eligible){
                          alertify.error("Insufficient points or points usage reached.");
                          return;
                        }

                        var choicesContainer = $('#choices_' + assessment_id + '_' + item_num);
                        
                        var correctChoices = response.assessment_items[item_num]['correct_choice'];

                        var choices = choicesContainer.find('input[type="radio"]');

                        var shuffledChoices = choices.sort(function(){ return 0.5 - Math.random() });

                        console.log(correctChoices);
                        shuffledChoices.each(function() {
                            if ($(this).parent().is(':visible') && correctChoices.indexOf($(this).val()) !== -1) {
                              console.log($(this).parent());
                                $(this).parent().addClass('text-green-700');
                                return false;
                            }
                        });

                        document.getElementById('user_points').innerHTML = 'Points: ' + response.remaining_points;
                        alertify.success('Send Help used');
                    },
                    error: function(xhr, status, error) {
                      console.log(error);
                    }
                  });
                }
                else if (action === '50-50'){
                  
                  $.ajax({
                    type: 'POST',
                    url: '{{route("assessment.5050")}}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        action: action,
                        data: {
                          course_id: courseId,
                          assessment_id: assessment_id,
                        }
                    },
                    success: function(response) {
                        if (!response.eligible){
                          alertify.error("Insufficient points or points usage reached.");
                          return;
                        }
                        var choicesContainer = $('#choices_' + assessment_id + '_' + item_num);
                        
                        var correctChoices = response.assessment_items[item_num]['correct_choice'];
                        
                        var choices = choicesContainer.find('input[type="radio"]');

                        var shuffledChoices = choices.sort(function(){ return 0.5 - Math.random() });
                        
                        var removedCount = 0;
                        shuffledChoices.each(function() {
                            if (removedCount < 2 && $(this).parent().is(':visible') && correctChoices.indexOf($(this).val()) === -1) {
                                $(this).parent().hide();
                                removedCount++;
                            }
                        });
                        document.getElementById('user_points').innerHTML = 'Points: ' + response.remaining_points;
                        alertify.success('50/50 used');
                    },
                    error: function(xhr, status, error) {
                      console.log(error);
                    }
                  });
                }
                else if (action === '1by1'){
                  $.ajax({
                    type: 'POST',
                    url: '{{route("assessment.1by1")}}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        action: action,
                        data: {
                          course_id: courseId,
                          assessment_id: assessment_id,
                        }
                    },
                    success: function(response) {
                      if (!response.eligible){
                          alertify.error("Insufficient points or points usage reached.");
                          return;
                        }
                        var choicesContainer = $('#choices_' + assessment_id + '_' + item_num);
                        
                        var correctChoices = response.assessment_items[item_num]['correct_choice'];

                        var choices = choicesContainer.find('input[type="radio"]');

                        var shuffledChoices = choices.sort(function(){ return 0.5 - Math.random() });

                        shuffledChoices.each(function() {
                            if ($(this).parent().is(':visible') && correctChoices.indexOf($(this).val()) === -1) {
                                $(this).parent().hide();
                                return false;
                            }
                        });
                        document.getElementById('user_points').innerHTML = 'Points: ' + response.remaining_points;
                        alertify.success('1 by 1 used');
                    },
                    error: function(xhr, status, error) {
                      console.log(error);
                    }
                  });
                }
              },
              function(){
                alertify.error("Canceled.");
                return true;
              }
            )) return;
            
        });
    });
</script>
</html>