<?php
include_once("traits/DokelioFrontpageTrait.php");
include_once("traits/DokelioDomainsTrait.php");

/**
 * Handles all interactions between CDMA's website and Dokelio
 */
Class Dokelio {
  use DokelioFrontpageTrait;
  use DokelioDomainsTrait;
}
