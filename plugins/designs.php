<?php

/** Allow switching designs
* @link https://www.adminer.org/plugins/#use
* @author Jakub Vrana, https://www.vrana.cz/
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerDesigns extends Adminer\Plugin {
	protected $designs;

	/**
	* @param list<string> $designs URL in key, name in value
	*/
	function __construct(array $designs) {
		$this->designs = $designs;
	}

	function headers() {
		if (isset($_POST["design"]) && Adminer\verify_token()) {
			Adminer\restart_session();
			$_SESSION["design"] = $_POST["design"];
			Adminer\redirect($_SERVER["REQUEST_URI"]);
		}
	}

	function css() {
		$return = array();
		if (array_key_exists($_SESSION["design"], $this->designs)) {
			$return[$_SESSION["design"]] = (preg_match('~-dark~', $_SESSION["design"]) ? "dark" : "light");
		}
		return $return;
	}

	function navigation($missing) {
		echo "<form action='' method='post' style='position: fixed; bottom: .5em; right: .5em;'>";
		echo Adminer\html_select("design", array("" => "(design)") + $this->designs, $_SESSION["design"], "this.form.submit();");
		echo Adminer\input_token();
		echo "</form>\n";
	}

	function screenshot() {
		return "https://www.adminer.org/static/plugins/designs.png";
	}

	protected $translations = array(
		'cs' => array('' => 'Umožní změnit vzhled'),
		'de' => array('' => 'Designwechsel ermöglichen'),
		'pl' => array('' => 'Zezwalaj na przełączanie motywów'),
		'ro' => array('' => 'Permiteți comutarea designurilor'),
		'ja' => array('' => 'テーマ設定を有効化'),
	);
}
