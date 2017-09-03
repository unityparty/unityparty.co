<?php

	function bbParse($str) {

		$letters = str_split($str);
		$parsed = "";
		$skip = 0;
		foreach ($letters as $key => $letter) {
			if ($skip !== 0) {
				$skip -= 1;
			} else {
				if ($letter == "[") {

					if ($letters[$key + 1] == "b" && $letters[$key + 2] == "]") { // OPEN BOLD
						$parsed = $parsed . "<b>";
						$skip = 2;
					} elseif ($letters[$key + 1] == "/" && $letters[$key + 2] == "b" && $letters[$key+3] == "]") { // CLOSE BOLD
						$parsed = $parsed . "</b>";
						$skip = 3;
					} elseif ($letters[$key + 1] == "i" && $letters[$key + 2] == "]") { // OPEN ITALICS
						$parsed = $parsed . "<i>";
						$skip = 2;
					} elseif ($letters[$key + 1] == "/" && $letters[$key + 2] == "i" && $letters[$key+3] == "]") { // CLOSE ITALICS
						$parsed = $parsed . "</i>";
						$skip = 3;
					} elseif ($letters[$key + 1] == "u" && $letters[$key + 2] == "]") { // OPEN UNDERLINE
						$parsed = $parsed . "<u>";
						$skip = 2;
					} elseif ($letters[$key + 1] == "/" && $letters[$key + 2] == "u" && $letters[$key+3] == "]") { // CLOSE UNDERLINE
						$parsed = $parsed . "</u>";
						$skip = 3;
					} elseif ($letters[$key + 1] == "u" && $letters[$key + 2] == "r" && $letters[$key + 3] == "l" && $letters[$key + 4] == "]") { // OPEN URL (NOT SPECIFIED)
						$parsed = $parsed . "<a href=\"";
						$skip = 4;
						$tmp = $key + 5;
					} elseif ($letters[$key + 1] == "/" && $letters[$key + 2] == "u" && $letters[$key+3] == "r") { // CLOSE URL
						$parsed = $parsed . "\">" . substr($str, $tmp, $key - $tmp) . "</a>";
						$skip = 5;
					} else { // OPEN NOTHING
						$parsed = $parsed . "[";
					}

				} else {
					$parsed = $parsed . $letter;
				}
			}
		}

		return $parsed;

	}

?>