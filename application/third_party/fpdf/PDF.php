<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PDF extends FPDF_Protection{
	var $widths;
	var $aligns;
	
	function RotatedText($x,$y,$txt,$angle)
	{
	    //Text rotated around its origin
	    $this->Rotate($angle,$x,$y);
	    $this->Text($x,$y,$txt);
	    $this->Rotate(0);
	}

	function RotatedImage($file,$x,$y,$w,$h,$angle)
	{
	    //Image rotated around its upper-left corner
	    $this->Rotate($angle,$x,$y);
	    $this->Image($file,$x,$y,$w,$h);
	    $this->Rotate(0);
	}

	// Simple table
	function BasicTable($header, $data)
	{
	    // Header
	    foreach($header as $col)
	        $this->Cell(40,7,$col,1);
	    $this->Ln();
	    // Data
	    foreach($data as $row)
	    {
	        foreach($row as $col)
	        $this->Cell(40,6,$col,1);
	        $this->Ln();
	    }
	}

	// Better table
	function ImprovedTable($header, $data)
	{
	    // Column widths
	    $w = array(40, 35, 40, 45);
	    // Header
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C');
	    $this->Ln();
	    // Data
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR');
	        $this->Cell($w[1],6,$row[1],'LR');
	        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
	        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
	        $this->Ln();
	    }
	    // Closing line
	    $this->Cell(array_sum($w),0,'','T');
	}

	// Colored table
	function FancyTable($header, $data)
	{
	    // Colors, line width and bold font
	    $this->SetFillColor(255,0,0);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(128,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B');
	    // Header
	    $w = array(40, 35, 40, 45);
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	    $this->Ln();
	    // Color and font restoration
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    // Data
	    $fill = false;
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
	        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
	        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
	        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
	        $this->Ln();
	        $fill = !$fill;
	    }
	    // Closing line
	    $this->Cell(array_sum($w),0,'','T');
	}

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

function IndentMultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $indent=0)
{
    //Output text with automatic or explicit line breaks
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;

    $wFirst = $w-$indent;
    $wOther = $w;

    $wmaxFirst=($wFirst-2*$this->cMargin)*1000/$this->FontSize;
    $wmaxOther=($wOther-2*$this->cMargin)*1000/$this->FontSize;

    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 && $s[$nb-1]=="\n")
        $nb--;
    $b=0;
    if($border)
    {
        if($border==1)
        {
            $border='LTRB';
            $b='LRT';
            $b2='LR';
        }
        else
        {
            $b2='';
            if(is_int(strpos($border,'L')))
                $b2.='L';
            if(is_int(strpos($border,'R')))
                $b2.='R';
            $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
        }
    }
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $ns=0;
    $nl=1;
        $first=true;
    while($i<$nb)
    {
        //Get next character
        $c=$s[$i];
        if($c=="\n")
        {
            //Explicit line break
            if($this->ws>0)
            {
                $this->ws=0;
                $this->_out('0 Tw');
            }
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border && $nl==2)
                $b=$b2;
            continue;
        }
        if($c==' ')
        {
            $sep=$i;
            $ls=$l;
            $ns++;
        }
        $l+=$cw[$c];

        if ($first)
        {
            $wmax = $wmaxFirst;
            $w = $wFirst;
        }
        else
        {
            $wmax = $wmaxOther;
            $w = $wOther;
        }

        if($l>$wmax)
        {
            //Automatic line break
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
                if($this->ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $SaveX = $this->x; 
                if ($first && $indent>0)
                {
                    $this->SetX($this->x + $indent);
                    $first=false;
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                    $this->SetX($SaveX);
            }
            else
            {
                if($align=='J')
                {
                    $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                    $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
                }
                $SaveX = $this->x; 
                if ($first && $indent>0)
                {
                    $this->SetX($this->x + $indent);
                    $first=false;
                }
                $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                    $this->SetX($SaveX);
                $i=$sep+1;
            }
            $sep=-1;
            $j=$i;
            $l=0;
            $ns=0;
            $nl++;
            if($border && $nl==2)
                $b=$b2;
        }
        else
            $i++;
    }
    //Last chunk
    if($this->ws>0)
    {
        $this->ws=0;
        $this->_out('0 Tw');
    }
    if($border && is_int(strpos($border,'B')))
        $b.='B';
    $this->Cell($w,$h,substr($s,$j,$i),$b,2,$align,$fill);
    $this->x=$this->lMargin;
    }

}

?>