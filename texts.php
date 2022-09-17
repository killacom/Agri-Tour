<?php
$make_res_pw_info = 'If you think you might need to come back later and make changes to your reservation, please enter a password. This password will be specific to this reservation.';
$greentext_text = 'Hours in green are available for booking.';
$orangetext_text = 'Hours in orange have a large amount of reservations booked for that time already.';
$redtext_text = 'Hours in red are already too booked for a group your size.';
$calendar_message = 'If you feel you need a time and date that is already fully booked
                    or otherwise not available please call us at 919-451-5534 to see if an exception can be made.';
$calendar_header_text = 'Please click on a time to select it for your reservation.<br />
                         Times after 11:30 are always open.';
$too_early_text = 'You have chosen a date before the farm opens. Please choose another date. See top of page or calendar for open dates.';
$too_booked_text = 'You have chose a date which is already full for reservations. Please choose another date. See calendar for open dates.';
$farm_closed_text = 'You have chose a date when the farm is not open for reservations. Please choose another date. See top of page or calendar for open dates.';
$too_late_text= 'You may only place a reservation for tomorrow or later. Today is '.date("M/d/Y").'.';
$contact_first_name_missing_text = 'Please enter contact first name.';
$contact_last_name_missing_text =  'Please enter contact last name.';
$school_name_missing_text = 'Please enter school or organization name.';
$num_children_missing_text = 'Please enter estimated number of children.';
$must_be_num_text = 'This field must be a number.';
$num_teachers_missing_text = 'Please enter estimated number of teachers.';
$phone_missing_text = 'Please enter contact phone number.';
$must_be_10_text = 'This field must be a 10 digit number.';
$password_mismatch_text = 'Passwords do not match.';
$userpass_combo_bad_text = 'Username/Password Combination No Good.';
$reservation_success_text = 'Thank you for your reservation!<br>
            Please allow up to an hour for your confirmation email to arrive; if you do not receive it please DO NOT try again.<br> 
            Check your Spam or Junk Mail folder to see if your email provider put it there. <br>
            You can see if your school name is  listed in the School Calendar at the bottom of our Field Trips  page, <br>
            or give us a call at 919-451-5534 to confirm that your reservation has been made.';
$edit_success_text = 'Thank you for the update on your reservation!<br>
            Please allow up to an hour for your confirmation email to arrive; if you do not receive it please DO NOT try again.<br> 
            Check your Spam or Junk Mail folder to see if your email provider put it there. <br>
            You can see your school name listed in the School Calendar at the bottom of our <a href="http://www.pagefarmsraleigh.com/testimonials.html">Field Trips page.</a><br>
            You may also view your reservation details by clicking the link below.';
$month_switcher = 
        "1: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']},
        2: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28']},
        3: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']},
        4: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30']},
        5: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']},
        6: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30']},
        7: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']},
        8: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']},
        9: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'], 
            value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30']},
        10: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], 
             value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']},
        11: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'], 
             value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30']},
        12: { text: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], 
             value: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31']}";

?>