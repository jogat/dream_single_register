<?php

class Register {

    static $current_emails = [
        'johndoe@gmail.com',
        'mark.anthony@otulook.com',
        'bruce.wayne@icloud.com',
        'peter.parker@yahoo.com',
        'barry.alen@yahoo.com',
        'clark.kent@yahoo.com',
        'diana.price@aol.com',
        'irena_ubrovna@yahoo.ca',
        'charles.xavier@msn.com',
        'tony.stark@msn.com'
    ];

    static $genders = [
        'm'=> 'Man Seeking a Woman',
        'f'=> 'Woman Seeking a Man',
    ];
    

    /**
     * Creates new account
     * return array
     */
    public function add($values = []) {
        $errors = $this->validate_parameters($values);

        if (!empty($errors)) {
            return [
                'success'=> false,
                'data'=> $errors
            ];
        }

        $gender = $values['gender'];
        $email = $values['email'];
        $password = $values['password'];
        $birthday =new DateTime(
            $values['bd']['day'] . "-". 
            $values['bd']['month'] . "-" . 
            $values['bd']['year']
        );

        
        $db = new PDO("mysql:dbname=single_dream;host=localhost", "root", "" );
                
        $query = $db->prepare('INSERT INTO `account` (`email`, `password`, `birthday`, `gender`) VALUES (?,?,?,?)');

        $query->execute([
            $values['email'],
            password_hash($values["password"], PASSWORD_BCRYPT),
            $values['bd']['year'] . '-' . $values['bd']['month'] . '-' . $values['bd']['day'],
            $values['gender']

        ]);

        $errorInfo =  $query->errorInfo();
        if (!empty($errorInfo[1])) {
            return [
                'success'=> false,
                'data'=> ['Failed to create your account.']
            ];            
        }

        return [
            'success'=> true,
            'data'=> 'Account created successfully!.'
        ];                 
    }

    public function validate_parameters($values=[]) {
        $errors = [];

        if (empty($values['gender']) || !in_array($values['gender'], array_keys(self::$genders))) {
            $errors[] = 'gender.';
        }

        if (in_array($values["email"], self::$current_emails)) {
            $errors[] = "Email already exists";
        } elseif (!filter_var($values["email"], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }

        if (empty($values['password'])) {
            $errors[] = 'password.';
        }

        if (empty($values['password_confirmation'])) {
            $errors[] = 'password confirmation.';
        }

        if ($values['password'] !== $values['password_confirmation']) {
            $errors[] = 'Passwords do not match.';
        } elseif (!preg_match('/((?=.*\d)(?=.*[a-z])).{8,}/', $values["password"]))  {
            $errors[] = 'Password must contain at least one letter and one number, and be at least 8 characters.';
        }
        

        if (empty($values['bd'])) {
            $errors[] = 'Birthday';
        } else {
            if ($values['bd']['month'] === '0') {
                $errors[] = 'Birthday month.';
            }

            if ($values['bd']['day'] === 'DD') {
                $errors[] = 'Birthday date';
            }

            if ($values['bd']['year'] === 'YYYY') {
                $errors[] = 'Birthday year.';
            }

            if (!checkdate(
                    (int)$values['bd']['month'],
                    (int)$values['bd']['day'],
                    (int)$values['bd']['year']
                )
            ) {
                $errors[] = 'Valid birthdate.';
            } else {
                $today = new DateTime(date("d-m-Y"));
                $birthday = new DateTime(
                    $values['bd']['day'] . "-". 
                    $values['bd']['month'] . "-" . 
                    $values['bd']['year']
                );
            
                $interval = $birthday->diff($today);
            
                $age = $interval->y;
            
                if ($age < 18) {
                    $errors[] = 'Must be at least 18 to register.';
                }
            }
        }
        return $errors;
    }
    

    /**
     * Get months, days and years
     * return array
     */
    static function calendar() {
        
        /*~~~~~~~~~~*/
        /*  Months  */
        /*~~~~~~~~~~*/
        $months = [
            '0'=> 'MM',
            '1'=> 'January',
            '2'=> 'Fabruray',
            '3'=> 'March',
            '4'=> 'April',
            '5'=> 'May',
            '6'=> 'June',
            '7'=> 'July',
            '8'=> 'August',
            '9'=> 'September',
            '10'=> 'October',
            '11'=> 'November',
            '12'=> 'December'
        ];


        /*~~~~~~~~*/
        /*  Days  */
        /*~~~~~~~~*/

        $days = ['DD'];
        for ($i=1; $i <= 31; $i++) { 
            $days[] = $i;
        }

        /*~~~~~~~~~*/
        /*  Years  */
        /*~~~~~~~~~*/

        $years = ['YYYY'];

        $start_year = date("Y") - 18;
        $end_year = $start_year - 60;
                
        for ($i=$start_year; $i >= $end_year; $i--) { 
           $years[] = $i;
        }


        return [
            'months'=> $months,
            'days'=> $days,
            'years'=> $years
        ];

    }

    /**
     * Get Gender returns
     * return array
     */
    static function gender() {
        return self::$genders;
    }
}