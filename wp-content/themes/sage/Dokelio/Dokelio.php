<?php
include_once("traits/DokelioConnectionTrait.php");
include_once("traits/DokelioFrontpageTrait.php");
include_once("traits/DokelioDomainsTrait.php");

/**
 * Handles all interactions between CDMA's website and Dokelio
 */
Class Dokelio {
  use DokelioConnectionTrait;
  use DokelioFrontpageTrait;
  use DokelioDomainsTrait;

  public static function __staticConstructor() {
    self::getConnection();
  }

  public static function toSlug($str, $delimiter = '-') {
    $unwanted_chars = ['à' => 'a', 'ç' => 'c', 'é' => 'e', 'è' => 'e', 'ù' => 'ù'];
    $str = strtr( $str, $unwanted_chars );
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));

    return $slug;
  }

  public static function codeAFToId($code_AF) {
    return substr($code_AF, strpos($code_AF, "_") + 1, strlen($code_AF) - 1);
  }
}
Dokelio::__staticConstructor();
