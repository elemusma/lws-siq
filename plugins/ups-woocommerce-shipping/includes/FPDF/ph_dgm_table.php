<?php
require('fpdf.php');

class PH_DGM_Table extends FPDF {

	var $widths;
	var $aligns;

	function PH_SetWidths($w) {
		// Set the array of column widths
		$this->widths = $w;
	}

	function PH_SetAligns($a) {
		// Set the array of column alignments
		$this->aligns = $a;
	}

	function PH_Row( $data, $heading = false ) {

		//Calculate the height of the row
		$nb = 0;

		for( $i = 0; $i < count($data); $i++ ) {
			$nb = max( $nb, $this->PH_NbLines( $this->widths[$i], $data[$i] ) );
		}

		$h = 6*$nb;

		//Issue a page break first if needed
		$this->PH_CheckPageBreak($h);
		
		if( !$heading ) {
			$this->Ln(7);
		}
		
	
		//Draw the cells of the row
		for( $i = 0; $i < count($data); $i++ ) {

			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
			
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			
			//Draw the border
			$this->Rect( $x, $y-5, $w, $h+7 );

			//Print the text
			$this->MultiCell( $w, 6, $data[$i], 0, $a );
			
			//Put the position to the right of the cell
			$this->SetXY( $x+$w, $y );
		}
		
		//Go to the next line
		$this->Ln($h);
	}

	function PH_CheckPageBreak($h) {
		//If the height h would cause an overflow, add a new page immediately
		if( $this->GetY()+$h>$this->PageBreakTrigger ) {
			$this->AddPage($this->CurOrientation);
		}
	}

	function PH_NbLines($w,$txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];

		if( $w==0 ) {
			$w = $this->w-$this->rMargin-$this->x;
		}

		$wmax 	= ( $w-2*$this->cMargin )*1000/$this->FontSize;
		$s 		= str_replace("\r",'',$txt);
		$nb 	= strlen($s);

		if( $nb>0 && $s[$nb-1]=="\n" ) {
			$nb--;
		}

		$sep 	= -1;
		$i 		= 0;
		$j 		= 0;
		$l 		= 0;
		$nl 	= 1;

		while($i<$nb) {

			$c = $s[$i];

			if( $c=="\n" ) {

				$i++;
				$sep 	= -1;
				$j 		= $i;
				$l 		= 0;
				$nl++;
				continue;
			}

			if( $c==' ' ) {
				$sep=$i;
			}

			$l += $cw[$c];

			if( $l>$wmax ) {
				if( $sep==-1 ) {
					if( $i==$j ) {
						$i++;
					}
				} else {
					$i = $sep+1;
				}

				$sep 	= -1;
				$j 		= $i;
				$l 		= 0;
				$nl++;
			} else {
				$i++;
			}
		}
		return $nl;
	}
}