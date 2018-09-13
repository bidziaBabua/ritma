<?php
function searchWord($servername, $username, $serverPassword, $DBname, $testWord){
    $conn=mysqli_connect($servername, $username, $serverPassword, $DBname);
    mysqli_set_charset( $conn, 'utf8' );
    if(!$conn){
        die("Connection ERROR: ".mysqli_connect_error());
    }
    $arr = preg_split('//u', $testWord, -1, PREG_SPLIT_NO_EMPTY); //UTF-8
    $vowels=array();
    $consonants=array();
    $newWordArr=array(); $wordLen=0;
    foreach($arr as $w){
        if($w=="ა" || $w=="ე" || $w=="ი" || $w=="ო" || $w=="უ"){
            array_push($vowels, $w);
        }
        else{
            array_push($consonants, $w);
        }
        array_push($newWordArr, $w); $wordLen++;
    }
    $newWord=implode('', $newWordArr);
    $vowelsStr = implode('', $vowels);
    $consonantsStr=implode('', $consonants);
    $sql="SELECT word FROM words WHERE vowels = '$vowelsStr'";
    $result=mysqli_query($conn, $sql);
    ?>

    <div class="col-sm-6 col-md-6 col-lg-10" style="left: 200px"><?php
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo $row["word"]."<br />";
        }
    }
    else {
        echo "ჩანაწერი არ მოიძებნა!";
    }
    ?><br /></div><?php
    mysqli_close($conn);
}

function addNewWord($servername, $username, $serverPassword, $DBname, $testWord){
    $conn=mysqli_connect($servername, $username, $serverPassword, $DBname);
    mysqli_set_charset( $conn, 'utf8' );
    if(!$conn){
        die("Connection ERROR: ".mysqli_connect_error());
    }
    $arr = preg_split('//u', $testWord, -1, PREG_SPLIT_NO_EMPTY); //UTF-8
    if(isAlreadyInDB($conn, $testWord)){
        ?>

        <div class="col-sm-6 col-md-6 col-lg-10" style="left: 200px; font-size: 24px; color: red"><?php
        echo "ასეთი სიტყვა უკვე არსებობს ბაზაში..";
        ?><br /></div><?php
    }
    else{
        $vowels=array();
        $consonants=array();
        $newWordArr=array(); $wordLen=0;
        foreach($arr as $w){
            if($w=="ა" || $w=="ე" || $w=="ი" || $w=="ო" || $w=="უ"){
                array_push($vowels, $w);
            }
            else{
                array_push($consonants, $w);
            }
            array_push($newWordArr, $w); $wordLen++;
        }
        $newWord=implode('', $newWordArr);
        $vowelsStr = implode('', $vowels);
        $consonantsStr=implode('', $consonants);
        $sql="INSERT INTO `words` (`id`, `word`, `vowels`, `consonants`, `length`) VALUES
            (NULL, '$newWord', '$vowelsStr', '$consonantsStr', '$wordLen');";
        $result=mysqli_query($conn, $sql);
        ?>

        <div class="col-sm-6 col-md-6 col-lg-10" style="left: 200px; font-size: 24px; color: 	#A4C439"><?php
        echo "სიტყვა წარმატებით დაემატა";
        ?><br /></div><?php
    }
    mysqli_close($conn);
}

function isAlreadyInDB($conn, $testWord){
    mysqli_set_charset( $conn, 'utf8' );
    if(!$conn){
        die("Connection ERROR: ".mysqli_connect_error());
    }
    $testWordUTF8 = preg_split('//u', $testWord, -1, PREG_SPLIT_NO_EMPTY); //UTF-8
    $newWord=implode('', $testWordUTF8);
    $sql="SELECT word FROM words WHERE word = '$newWord'";
    $result=mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    else{
        return false;
    }
    mysqli_close($conn);
    echo("TEST");
}

?>