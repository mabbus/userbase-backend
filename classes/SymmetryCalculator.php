<?php

class SymmetryCalculator {
    var $marks;

    public function SymmetryCalculator($landmarks) {
        $this->marks = $landmarks;
    }

    function getCalc ($x1, $y1, $x2, $y2, $x3, $y3) {
        $calc = (sqrt(
            pow($x1 - $x2, 2) + 
            pow($y1 - $y2, 2)
        )) - (sqrt(
            pow($x1 - $x3, 2) + 
            pow($y1 - $y3, 2)
        ));
        if($calc < 0) {
            $calc = -($calc);
        }
        return $calc;
    }
    //1
    function EyeInnerToNoseBase () {
        $m = $this->marks;
        $val = $this->getCalc($m[41]->x, $m[41]->y, $m[34]->x, $m[34]->y, $m[37]->x, $m[37]->y);
        return $val;
    }
    //2
    function EyeOuterToNoseBase () {
        $m = $this->marks;
        $val = $this->getCalc($m[41]->x, $m[41]->y, $m[32]->x, $m[32]->y, $m[27]->x, $m[27]->y);
        return $val;
    }
    //3
    function EyeInnerToMouthMid () {
        $m = $this->marks;
        $val = $this->getCalc($m[61]->x, $m[61]->y, $m[34]->x, $m[34]->y, $m[37]->x, $m[37]->y);
        return $val;
    }
    //4
    function EyeOuterToMouthMid () {
        $m = $this->marks;
        $val = $this->getCalc($m[61]->x, $m[61]->y, $m[32]->x, $m[32]->y, $m[27]->x, $m[27]->y);
        return $val;
    }
    //5
    function EyebrowInnerToNoseBase () {
        $m = $this->marks;
        $val = $this->getCalc($m[41]->x, $m[41]->y, $m[18]->x, $m[18]->y, $m[24]->x, $m[24]->y);
        return $val;
    }
    //6
    function EyebrowOuterToNoseBase () {
        $m = $this->marks;
        $val = $this->getCalc($m[61]->x, $m[61]->y, $m[34]->x, $m[34]->y, $m[37]->x, $m[37]->y);
        return $val;
    }
    //7
    function EyebrowTopToNoseBase1 () {
        $m = $this->marks;
        $val = $this->getCalc($m[41]->x, $m[41]->y, $m[17]->x, $m[17]->y, $m[23]->x, $m[23]->y);
        return $val;
    }
    //8
    function EyebrowTopToNoseBase2 () {
        $m = $this->marks;
        $val = $this->getCalc($m[41]->x, $m[41]->y, $m[16]->x, $m[16]->y, $m[22]->x, $m[22]->y);
        return $val;
    }
    //9
    function NoseTipToUpperNose () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[45]->x, $m[45]->y, $m[37]->x, $m[37]->y);
        return $val;
    }
    //10
    function NoseTipToLowerNose () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[43]->x, $m[43]->y, $m[39]->x, $m[39]->y);
        return $val;
    }
    //11
    function NoseTipToOuterMouth () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[54]->x, $m[54]->y, $m[48]->x, $m[48]->y);
        return $val;
    }
    //12
    function NoseTipToTopMouth () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[49]->x, $m[49]->y, $m[53]->x, $m[53]->y);
        return $val;
    }
    //13
    function NoseTipToLowerMouth () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[55]->x, $m[55]->y, $m[59]->x, $m[59]->y);
        return $val;
    }
    //14
    function NoseTipToChinAxis () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[10]->x, $m[10]->y, $m[4]->x, $m[4]->y);
        return $val;
    }
    //15
    function NoseTipToLowerChinAxis () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[5]->x, $m[5]->y, $m[9]->x, $m[9]->y);
        return $val;
           
    }
    //16
    function NoseTipToUpperNose2 () {
        $m = $this->marks;
        $val = $this->getCalc($m[67]->x, $m[67]->y, $m[6]->x, $m[6]->y, $m[8]->x, $m[8]->y);
        return $val;
    }

    function calculatePercentage () {
        $sum = 
            $this->EyeInnerToNoseBase() +
            $this->EyeOuterToNoseBase() +
            $this->EyeInnerToMouthMid() +
            $this->EyeOuterToMouthMid() +
            $this->EyebrowInnerToNoseBase() +
            $this->EyebrowOuterToNoseBase() +
            $this->EyebrowTopToNoseBase1() +
            $this->EyebrowTopToNoseBase2() +
            $this->NoseTipToUpperNose() +
            $this->NoseTipToLowerNose() +
            $this->NoseTipToOuterMouth() +
            $this->NoseTipToTopMouth() +
            $this->NoseTipToLowerMouth() +
            $this->NoseTipToChinAxis() +
            $this->NoseTipToLowerChinAxis() + 
            $this->NoseTipToUpperNose2();
        
        
        return $sum;
    }
}