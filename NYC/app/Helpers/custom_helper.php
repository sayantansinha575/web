<?php
// Function: used to convert a string to revese in order
use Picqer\Barcode;
use Picqer\Barcode\BarcodeGeneratorPNG;

if (!function_exists("is_headoffice")) {
    function is_headoffice($id = 0)
    {
        $db = db_connect();
        $builder = $db->table('users');
        $session = \Config\Services::session();
        $id?$id:$id=$session->userData['id'];
        if ($session->isLoggedIn) {
            $builder->select('group_id');
            $builder->where('id', $id);
            $builder->limit(1);
            $data = $builder->get()->getRow();
            if ($data->group_id == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists("is_employer")) {
    function is_employer($id = 0)
    {
        $db = db_connect();
        $builder = $db->table('users');
        $session = \Config\Services::session();
        $id=$session->empData['id']; 
        if ($session->isEmpLoggedIn) {
            $builder->select('group_id');
            $builder->where('id', $id);
            $builder->limit(1);
            $data = $builder->get()->getRow();
            if ($data->group_id == 2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists("is_student")) {
    function is_student($id = 0)
    {
        $db = db_connect();
        $builder = $db->table('student');
        $session = \Config\Services::session();
        $id?$id:$id= @($session->studData['id'])?($session->studData['id']):'';
        if ($session->isStudLoggedIn) {
            $builder->select('id');
            $builder->where('id', $id);
            $builder->limit(1);
            $data = $builder->get()->getRow();
            if ($data) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists("is_branch")) {
    function is_branch($id = 0)
    {
        $db = db_connect();
        $builder = $db->table('branch');
        $session = \Config\Services::session();
        $id?$id:$id= @($session->branchData['id'])?($session->branchData['id']):'';
        if ($session->isBranchLoggedIn) {
            $builder->select('id');
            $builder->where('id', $id);
            $builder->limit(1);
            $data = $builder->get()->getRow();
            if ($data) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists("random_string")) {
    function random_string(int $length = 0, string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string
    {
        if ($length < 1) {
            return false;
            die;
        }
        $keyspace = str_shuffle($keyspace);
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
}

if (!function_exists("is_duplicate")) {
    function is_duplicate($table = '', $select = '', $where = array())
    {
        if (!empty($table)) {
            $db = db_connect();
            $builder = $db->table($table);
            $builder->select($select);
            if (!empty($where)) {
                $builder->where($where);
            }
            $count = $builder->countAllResults();
            if ($count == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}

if (!function_exists('isValidEmail')) {
    function isValidEmail($email){ 
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('clean')) {
    function clean($string = '')
    {
        $string = str_replace(' ', '', $string);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}

if (!function_exists('pr')) {
    function pr($dataArr, $die = true)
    {
        echo "<pre>";
        print_r($dataArr);
        if ($die) {
            die;
        }
    }
}

if (!function_exists('get_count')) {
    function get_count($table, $where = ''){
        $db = db_connect();
        $builder = $db->table($table);
        $builder->select('id');
        if (!empty($where)) {
            $builder->where($where);
        }
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile($path='', $fieldName='', $oldFile='', $fileName = '')
    {
        $name = '';
        if (!empty($_FILES[$fieldName]['tmp_name'])) {
            $path = $path;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if (empty($fileName)) {
                $fileName = md5(uniqid(mt_rand()));
            }else {
                $fileName = $fileName;
            }

            $tmp_name = $_FILES[$fieldName]['tmp_name'];
            $name = $_FILES[$fieldName]['name'];
            $nameArr = explode('.',$name);
            $ext = end($nameArr);
            $name = $fileName.'.'.$ext;
            if (move_uploaded_file($tmp_name, $path.'/'.$name)) {
                if (!empty($oldFile)) {
                    $path = $path.'/';
                    if (file_exists($path.$oldFile)) {
                        unlink($path.$oldFile);
                    }
                }
                return $name;
            };
        }
    }
}

if (!function_exists('uploadFileMultiple')) {
    function uploadFileMultiple($path='', $fieldName='', $oldFile='', $fileName = '')
    {
        $name = '';
        $fileNameArr = array();
        if (!empty($_FILES[$fieldName]['tmp_name'][0])) {
            $path = $path;
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $limit = count($_FILES[$fieldName]['tmp_name']);
            for ($i = 0; $i < $limit; $i++) {
                $tmp_name = $_FILES[$fieldName]['tmp_name'][$i];
                $name = $_FILES[$fieldName]['name'][$i];
                $nameArr = explode('.',$name);

                if (empty($fileName)) {
                    $fileNames = md5(uniqid(mt_rand()));
                }else {
                    $fileNames = $nameArr[0].$fileName;
                }
                
                $ext = end($nameArr);
                $name = $fileNames.'.'.$ext;
                if (move_uploaded_file($tmp_name, $path.'/'.$name)) {
                    if (!empty($oldFile)) {
                        $path = $path.'/';
                        if (file_exists($path.$oldFile)) {
                            unlink($path.$oldFile);
                        }
                    }
                    $fileNameArr[] =  $name;
                };
            }
            return $fileNameArr;
        }
    }
}

if (!function_exists('limitString')) {
    function limitString($text, $limit) 
    {
        $text = strip_tags($text);
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}

if (!function_exists('error')) {
    function error($data) 
    {
        echo json_encode($data); die;
    }
}

if (!function_exists('getModifiedBy')) {
    function getModifiedBy($id, $data = array()) 
    {
        $session = \Config\Services::session();
        $modArr[] = array(
            'id' => $session->userData['id'],
            'timestramp' => strtotime('now'),
            'clientIp' => filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP),
        );
        if (!empty($data)) {
            $data = unserialize($data);
            $modArr[] = $data;
        }
        return $modArr;
    }
}

if (!function_exists('getWalletBalance')) {
    function getWalletBalance($branchId = 0) 
    {
        $session = \Config\Services::session();
        if (empty($branchId)) {
            $id = $session->branchData['id'];
        }else {
            $id = $branchId;
        }
        $db = db_connect();
        $builder = $db->table('wallet');
        $builder->selectSum('amount');
        $builder->where('transaction_type', 1);
        $builder->where('branch', $id);
        $credited = $builder->get()->getRow()->amount;
        $builder = $db->table('wallet');
        $builder->selectSum('amount');
        $builder->where('transaction_type', 2);
        $builder->where('branch', $id);
        $debited = $builder->get()->getRow()->amount;

       return $credited - $debited;
        
    }
}
if (!function_exists('renewalDateLeft')) {
    function renewalDateLeft($branchId = 0) 
    {
        $session = \Config\Services::session();
        if (empty($branchId)) {
            $id = $session->branchData['id'];
        }else {
            $id = $branchId;
        }
        $db = db_connect();
        $builder = $db->table('branch');
        $builder->select('renewal_date');
        $builder->where('id', $id);
        $renewal_date = $builder->get()->getRow()->renewal_date;
        if(time() < $renewal_date){
            $diff = abs($renewal_date - time());
            return round($diff/(60*60*24)).' Days left for renewal';
        }else{
            return '<span class="text-danger"> 0 Days left for renewal</span>';
        }
    }
}
if (!function_exists('encrypt')) {
    function encrypt($string) 
    {
        $output = false;
        $key = hash('sha256', getenv('secret_key'));
        $iv = substr(hash('sha256', getenv('secret_iv')), 0, 16);
        $output = openssl_encrypt($string, getenv('encrypt_method'), $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }
}

if (!function_exists('decrypt')) {
    function decrypt($string) 
    {
        $output = false;
        $key = hash('sha256', getenv('secret_key'));
        $iv = substr(hash('sha256', getenv('secret_iv')), 0, 16);
        $output = openssl_decrypt(base64_decode($string), getenv('encrypt_method'), $key, 0, $iv);
        return $output;
    }
}

if (!function_exists('leadingZero')) {
    function leadingZero($number, $requiredZeroes) 
    {
        return sprintf('%0'.$requiredZeroes.'d', $number);
    }
}

if (!function_exists('validateDate')) {
    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}

if (!function_exists('getPrefixByColumnName')) {
    function getPrefixByColumnName($column = ''){
        $db = db_connect();
        $session = \Config\Services::session();
        $builder = $db->table('branch');
        $builder->select('*');
        $builder->where('id', $session->branchData['id']);
        $prefix = $builder->get()->getRow()->$column;
        return $prefix;
    }
}

if (!function_exists('fieldValue')) {
    function fieldValue($table, $column = '', $where = ''){
        $db = db_connect();
        $session = \Config\Services::session();
        $builder = $db->table($table);
        $builder->select('*');
        if (!empty($where)) {
            $builder->where($where);
        }
        $val = $builder->get()->getRow()->$column;
        return $val;
    }
}

if (!function_exists('maxValue')) {
    function maxValue($table, $column = '', $where = ''){
        $db = db_connect();
        $session = \Config\Services::session();
        $builder = $db->table($table);
        $builder->selectMax($column);
        if (!empty($where)) {
            $builder->where($where);
        }
        $val = $builder->get()->getRow()->$column;
        return $val;
    }
}

if (!function_exists('slugify')) {
    function slugify($string, $spaceRepl = "-")
    {
        $string = str_replace("'", '-', $string);
        $string = str_replace("/", '-', $string);
        $string = str_replace(".", '-', $string);        
        $string = str_replace("²", '2', $string);
        return url_title(convert_accented_characters($string), true);
    }
}

if (!function_exists('numbertoWords')) {
    function numbertoWords($num)
    {
        $numberInput = $num; 
        $locale = 'en_US';
        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
        $in_words = numfmt_format($fmt, $numberInput);
        return $in_words;
    }
}

if (!function_exists('getGradeNPercentage')) {
    function getGradeNPercentage($totalNumbers = 0, $obtainedMarks = 0, $type = '')
    {
        if ((!empty($totalNumbers) && is_numeric($totalNumbers)) && (!empty($obtainedMarks) && is_numeric($obtainedMarks))) {
            $percentage = number_format(($obtainedMarks / $totalNumbers) * 100 , 2) ;
            $percentage = sprintf('%g',$percentage);
            if (strtoupper($type) == 'P') {
                return $percentage; die;
            }else{
                switch ($percentage) {
                    case ($percentage >= 80):
                        return 'A+';
                        break;

                    case ($percentage >= 70):
                        return 'A';
                        break;

                    case ($percentage >= 60):
                        return 'B+';
                        break;

                    case ($percentage >= 50):
                        return 'B';
                        break;

                    case ($percentage >= 40):
                        return 'C';
                        break;
                    default:
                        return 'FAILED';
                        break;
                }
            }
        }else {
            return false;
        }
    }
}

if (!function_exists('barcodes')) {
    function barcodes($string = '', $fileType = 'png' , $codeType = 'TYPE_CODE_128', $color='')
    {
        $path = 'upload/barcodes';
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        define('PATH', $path.'/');

        switch (strtolower($fileType)) {
            case 'png': // Pixel based PNG
            $fileName = 'barcode.png';
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            break;
            case 'svg': // Vector based SVG
            $fileName = 'barcode.svg';
            $generator = new \Picqer\Barcode\BarcodeGeneratorSVG();
            break;
            case 'jpg': // Pixel based JPG
            $fileName = 'barcode.jpg';
            $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
            break;
            case 'html': // Pixel based HTML
            $fileName = 'barcode.html';
            $generator = new \Picqer\Barcode\BarcodeGeneratorHTML();
            break;
            case 'vhtml': // Vector based HTML
            $fileName = 'barcode.html';
            $generator = new \Picqer\Barcode\BarcodeGeneratorDynamicHTML();
            break;
            default: // Pixel based PNG
            $fileName = 'barcode.png';
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            break;
        }
        file_put_contents(PATH.$fileName, $generator->getBarcode($string, $generator::TYPE_CODE_128, 3, 50, $color));
        return $fileName;
    }
}

if (!function_exists('barcode')) {
    function barcode($string = '', $width = 0, $fileType = '')
    {
        if (empty($fileType)) {
            $fileType = 'PNG';
        }
        $widthVal = '';
        if ($width > 0) {
            $widthVal = "width=$width"."px";
        }
        return "<img class='slow-images' $widthVal src ='/public/barcode/html/image.php?filetype=".$fileType."&dpi=72&scale=1&rotation=0&font_family=Arial.ttf&font_size=10&text=".$string."&thickness=50&start=NULL&code=BCGcode128' />";
    }
}

if (!function_exists('image_dimention_validation')) {
    function image_dimention_validation($image='',$required_width='',$required_height='')
    {
        $fileinfo = @getimagesize($image);
        $width = $fileinfo[0];
        $height = $fileinfo[1];
        if( $width != $required_width || $height != $required_height){
            return false;
        }
        return true;
    }
}

#GET COUNTS FOR DASHBOARD
if (!function_exists('studentsCount')) {
    function studentsCount($status = 0, $isDeleted = 0)
    {
        $db = db_connect();
        $session = \Config\Services::session();
        $builder = $db->table('student');
        $builder->select('id');
        if (is_branch()) {
            $builder->where('branch_id', $session->branchData['id']);
        }
        if (!empty($status)) {
            $builder->where('status', $status);
        }
        $builder->where('is_deleted', $isDeleted);
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('branchCount')) {
    function branchCount($status = 0)
    {
        $db = db_connect();
        $builder = $db->table('branch');
        $builder->select('id');
        if (!empty($status)) {
            $builder->where('status', $status);
        }
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('courseCountHo')) {
    function courseCountHo($status = 0)
    {
        $db = db_connect();
        $builder = $db->table('course');
        $builder->select('id');
        if (!empty($status)) {
            $builder->where('status', $status);
        }
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('branchPayment')) {
    function branchPayment()
    {
        $db = db_connect();
        $builder = $db->table('wallet');
        $builder->selectSum('amount');
        $builder->where('transaction_type', 2);
        $amount = $builder->get()->getRow()->amount;

        return $amount;
    }
}

if (!function_exists('studentPayment')) {
    function studentPayment()
    {
        $db = db_connect();
        $session = \Config\Services::session();
        $builder = $db->table('payment');
        $builder->selectSum('amount');
        if (is_branch()) {
            $builder->where('branch_id', $session->branchData['id']);
        }
        $amount = $builder->get()->getRow()->amount;

        return $amount;
    }
}

if (!function_exists('totalAmtPaidToHO')) {
    function totalAmtPaidToHO()
    {
        $db = db_connect();
        $session = \Config\Services::session();
        $builder = $db->table('wallet');
        $builder->selectSum('amount');
        if (is_branch()) {
            $builder->where('branch', $session->branchData['id']);
            $builder->where('transaction_type', 2);
        }
        $amount = $builder->get()->getRow()->amount;

        return $amount;
    }
}

if (!function_exists('totalDueAmount')) {
    function totalDueAmount()
    {
        $db = db_connect();
        $totalAmtPaid = studentPayment();
        $session = \Config\Services::session();
        $courseFees = $discount = $actualCourseFees = 0;
        $data = $db->table('payment')->select('course_fees, discount')->where('branch_id', $session->branchData['id'])->orderBy('id', 'ASC')->groupBy('admission_id')->get()->getResult();
        if (!empty($data)) {
            foreach ($data as $dt) {
                $courseFees += $dt->course_fees;
                $discount += $dt->discount;
            }
            $actualCourseFees = ($courseFees - $discount);
        }

        if (!empty($actualCourseFees)) {
            return ($actualCourseFees - $totalAmtPaid);
        } else {
            return 0;
        }
    }
}

if (!function_exists('admissionCount')) {
    function admissionCount()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $builder = $db->table('admission');
        $builder->select('id');
        if (is_branch()) {
            $builder->where('branch_id', $session->branchData['id']);
        }
        if (is_student()) {
            $builder->where('registration_number', $session->studData['registrationNumber']);
        }
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('marksheetCount')) {
    function marksheetCount()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $builder = $db->table('marksheets');
        $builder->select('id');
        if (is_branch()) {
            $builder->where('branch_id', $session->branchData['id']);
        }
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('certificateCount')) {
    function certificateCount()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $builder = $db->table('certificates');
        $builder->select('id');
        if (is_branch()) {
            $builder->where('branch_id', $session->branchData['id']);
        }
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}


if (!function_exists('marksheetCountStudPane')) {
    function marksheetCountStudPane()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $builder = $db->table('marksheets');
        $builder->select('marksheets.id');
        $builder->join('admission adm', 'adm.enrollment_number=marksheets.enrollment_number', 'left');
        $builder->where('adm.registration_number', $session->studData['registrationNumber']);
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('certificateCountStudPane')) {
    function certificateCountStudPane()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $builder = $db->table('certificates');
        $builder->select('certificates.id');
        $builder->join('admission adm', 'adm.enrollment_number=certificates.enrollment_number', 'left');
        $builder->where('adm.registration_number', $session->studData['registrationNumber']);
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('admitCountStudPane')) {
    function admitCountStudPane()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $builder = $db->table('admits');
        $builder->select('admits.id');
        $builder->join('admission adm', 'adm.enrollment_number=admits.enrollment_number', 'left');
        $builder->where('adm.registration_number', $session->studData['registrationNumber']);
        $count = $builder->countAllResults();
        if ($count > 0) {
            return $count;
        } else {
            return 0;
        }
    }
}

if (!function_exists('totalAmountPaidStudPane')) {
    function totalAmountPaidStudPane()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $builder = $db->table('payment');
        $builder->selectSum('amount');
        $builder->join('admission adm', 'adm.id=payment.admission_id', 'left');
        $builder->where('adm.registration_number', $session->studData['registrationNumber']);
        $amount = $builder->get()->getRow()->amount; 
        return $amount;
    }
}

if (!function_exists('checkPwdStrength')) {
    function checkPwdStrength($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        }else{
            return true;
        }
    }
}

if (!function_exists('activeBranchCourseCount')) {
    function activeBranchCourseCount()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $branchId = $session->branchData['id'];
        if (!empty($branchId)) {
            $builder = $db->table('course');
            $builder->select("course.*");
            $builder->join('course_type ct', 'ct.id=course.course_type', 'left');
            $builder->join('branch_to_course ctb', 'ctb.course_id=course.id', 'left');
            $builder->where('ctb.branch_id', $branchId);
            $builder->where('ctb.status', 1);
            $builder->where('course.status', 1);
            $builder->orderBy('course.id','desc');
            $count = $builder->countAllResults();
            return $count;
        }else {
            return 0;
        }
    }
}

if (!function_exists('branchSudentCount')) {
    function branchSudentCount()
    {
        $session = \Config\Services::session();
        $db = db_connect();
        $branchId = $session->branchData['id'];
        if (!empty($branchId)) {
            $builder = $db->table('student');
            $builder->select("*");
            $builder->where('branch_id', $branchId);
            $count = $builder->countAllResults();
            return $count;
        }else {
            return 0;
        }
    }
}