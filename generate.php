<?php

setlocale( LC_ALL, 'de_DE.UTF-8' );
ini_set( 'default_charset', 'UTF-8' );

require( dirname( __FILE__ ) . '/fpdf/fpdf.php' );

$lang = isset( $_GET['lang'] ) ? $_GET['lang'] : 'de';
$columns = isset( $_GET['columns'] ) ? $_GET['columns'] : 7;
$rows = isset( $_GET['rows'] ) ? $_GET['rows'] : 7;

$file = 'de' === $lang ? file( 'tasks_de.txt' ) : file( 'tasks_en.txt' );
$rand_keys = array_rand( $file, $rows * $columns );
shuffle( $rand_keys );

$title = 'de' === $lang ? 'Spielbrett, Oster-Tramp-Tage' : 'Playing Field, Easter-Hitch-Days';
$subject = 'de' === $lang ? 'Jede Menge Spaß!' : 'Fun, Fun, Fun!';
$visual_title = 'de' === $lang ? 'Oster-Tramp-Tage: Vier Gewinnt!' : 'Easter-Hitch-Days: Connect Four';
$few_words = 'de' === $lang ? 'Beweisfotos müssen nur gemacht werden wo vermerkt, es dürfen aber gerne mehr zum Ziel mitgebracht werden!' . "\n" . 'Denkt dran: Samstag, 22:00 Uhr, Hanging Gardens...' : 'Photographic proofs are only required where explicitly stated, but you may bring more, of course!' . "\n" . "Don't forget: Saturday 10 p.m., Hanging Gardens, Kiel...";
$output_name = 'de' === $lang ? 'Tramprennen_Ostern2014_4Gewinnt.pdf' : 'Tramprennen_Easter2014_Connect4.pdf';

$pdf = new FPDF( 'L', 'mm', 'A4' );

$pdf->SetAuthor( 'Tramprennen', true );
$pdf->SetTitle( $title, true );
$pdf->SetSubject( $subject, true );
$pdf->SetFont( 'Arial', '', 10 );

$pdf->AddFont( 'Exo','','exo.php' );
$pdf->AddFont( 'Exo','B','exob.php' );
$pdf->AddFont( 'Exo2','','exo2.php' );
$pdf->AddFont( 'Exo2','B','exo2b.php' );

$pdf->SetMargins( 10, 10, 10 );
$pdf->SetAutoPageBreak( 10 );
$pdf->AddPage();

$pdf->Image( 'logo.png', 10, 10, -300 );
$pdf->setX( 50 );

$pdf->SetFont( 'Exo2', 'B', 30 );
$pdf->Cell( 227, 25, $visual_title, 0, 0, 'C' );
$pdf->SetFont( 'Exo', 'B', 9 );
$pdf->SetXY( 10, 45 );

$lf = "\n";

$k = 0;
for ( $i = 1; $i <= $rows; $i++ ) {

	for ( $j = 1; $j <= $columns; $j++ ) {

		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$cell_width = ( 297 - 20 ) / $columns;
		$cell_height = 4 * 5;

		$the_string = iconv( 'UTF-8', 'windows-1252', $file[$rand_keys[$k]] );
		$words = explode( ' ', $the_string );

		$max = 21;
		$lines = 1;
		$line = '';
		$new_string = '';
		$final_lines = 5;
		$word_cnt = 0;
		foreach ( $words as $word ) {
			$word_cnt++;
			if ( 0 === mb_strlen( $line ) ) {
				$line = $word;
			} elseif ( ( mb_strlen( $line ) + mb_strlen( $word ) ) <= $max ) {
				$line .= ' ' . $word;
			} else {
				$new_string .= $line . $lf;
				$lines++;
				$line = $word;
			}
			if ( $word_cnt === count( $words ) ) {
				$new_string .= $line;
			}
		}

		if ( $lines < $final_lines ) {
			$more = $final_lines - $lines;
			$top = floor( $more / 2 );
			$bottom = floor( $more / 2 ) + ( $more % 2 );

			$new_string = str_repeat( $lf, $top ) . $new_string . str_repeat( $lf, $bottom );
		}

		$pdf->MultiCell( $cell_width, 4, $new_string, 1, 'C' );

		$next_x = $j == $columns ? 10 : $x + $cell_width;
		$next_y = $j == $columns ? $y + $cell_height : $y;

		$pdf->SetXY( $next_x, $next_y );

		$k++;
	}

}

$pdf->SetXY( 10, $next_y + 7 );
$pdf->SetFont( 'Exo', '', 9 );

$pdf->MultiCell( 277, 4, iconv( 'UTF-8', 'windows-1252', $few_words ), 0, 'C' );

$pdf->Output( $output_name, 'I' );

?>