<?php

/**
 * ANM22 Mail plugin for ANM22 WebBase.
 * 
 * This pluging generate a form to subscribe the user to the ANM22 Mail mailing list.
 */
class com_anm22_wb_editor_page_element_mail_subscribe extends com_anm22_wb_editor_page_element
{

    var $elementClass = "com_anm22_wb_editor_page_element_mail_subscribe";
    var $elementPlugin = "com_anm22_wb_mail";
    
    var $title;
    protected $headingTag = "h1";
    var $sendPeriod;
    var $privacy_url;
    var $adwordsScript;
    
    var $cssClass;
    
    var $inputName;
    var $inputSurname;
    var $inputEmail;
    var $inputPhone;
    
    var $mailLicense;
    var $mailList;

    /**
     * @deprecated since editor 3.0
     * 
     * Method to init the element.
     * 
     * @param SimpleXMLElement $xml Element data
     * @return void
     */
    public function importXMLdoJob($xml)
    {
        $this->title = $xml->title;
        $this->sendPeriod = $xml->sendPeriod;
        
        $this->privacy_url = htmlspecialchars_decode($xml->privacy_url);
        $this->adwordsScript = htmlspecialchars_decode($xml->adwordsScript);
        $this->cssClass = $xml->cssClass;
        $this->inputName = $xml->inputName;
        $this->inputSurname = $xml->inputSurname;
        $this->inputEmail = $xml->inputEmail;
        $this->inputPhone = $xml->inputPhone;
        
        $this->mailLicense = $xml->mailLicense;
        $this->mailList = intval($xml->mailList);
    }

    /**
     * Method to init the element.
     * 
     * @param mixed[] $data Element data
     * @return void
     */
    public function initData($data)
    {
        $this->title = $data['title'];
        if (isset($data['headingTag'])) {
            $this->setHeadingTag(htmlspecialchars_decode($data['headingTag']));
        }
        $this->sendPeriod = $data['sendPeriod'];
        
        if (isset($data['privacy_url']) && $data['privacy_url']) {
            $this->privacy_url = htmlspecialchars_decode($data['privacy_url']);
        }
        if (isset($data['adwordsScript']) && $data['adwordsScript']) {
            $this->adwordsScript = htmlspecialchars_decode($data['adwordsScript']);
        }
        $this->cssClass = $data['cssClass'];
        $this->inputName = $data['inputName'];
        $this->inputSurname = $data['inputSurname'];
        $this->inputEmail = $data['inputEmail'];
        $this->inputPhone = $data['inputPhone'];
        
        $this->mailLicense = $data['mailLicense'];
        $this->mailList = intval($data['mailList']);
    }

    /**
     * Render the page element
     * 
     * @return void
     */
    public function show()
    {
        ?>
        <div class="<?= $this->elementPlugin ?>_<?= $this->elementClass ?><?= (($this->cssClass) && ($this->cssClass != "")) ? " " . $this->cssClass : "" ?>">
            <?
            if (isset($_GET['wb_form_alarm']) && $_GET['wb_form_alarm'] == 2) {
                ?>
                <div class="form_response_alarm">Non è stato inserito correttamente l'indirizzo email.</div>
                <?
            } else if (isset($_GET['wb_form_alarm']) && $_GET['wb_form_alarm']) {
                ?>
                <div class="form_response_alarm">Ops! Non è stato possibile inviare la tua richiesta, riprova più tardi.</div>
                <?
            }
            if (isset($_GET['wb_mail_form_ok']) && $_GET['wb_mail_form_ok']) {
                ?>
                <div class="form_response_confirm">La tua richiesta è stata inoltrata correttamente. Ti risponderemo il prima possibile.</div>
                <!-- Google Code for Preiscrizione YourBeach Conversion Page -->
                <?
                if ($this->adwordsScript != "") {
                    ?>
                    <?= $this->adwordsScript ?>
                    <?
                }
            }
            ?>
            <?
            if ($this->title != "") {
                ?><<?= $this->headingTag ?> class="form-title"><?= $this->title ?></<?= $this->headingTag ?>><?
            }
            ?>
            <form id="com_anm22_wb_plugin_mail_sub_form" action="https://www.anm22.it/app/mail/mail_api_formNewSubscriber.php?list=<?= $this->mailList ?>&wb=<?= $this->mailLicense ?>&ecallback=<?= urlencode("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "?") ?>" method="post">
                <?
                if ($this->inputName) {
                    ?>
                    <div class="form_item_container">
                        <div class="form_item_description"><? if ($this->page->getPageLanguage() == "it") { ?>Nome<? } else { ?>Name<? } ?>*</div>
                        <input type="text" name="name"/>
                    </div>
                    <?
                }
                if ($this->inputSurname) {
                    ?>
                    <div class="form_item_container">
                        <div class="form_item_description"><? if ($this->page->getPageLanguage() == "it") { ?>Cognome<? } else { ?>Surname<? } ?>*</div>
                        <input type="text" name="surname"/>
                    </div>
                    <?
                }
                if ($this->inputEmail) {
                    ?>
                    <div class="form_item_container">
                        <div class="form_item_description"><? if ($this->page->getPageLanguage() == "it") { ?>Email<? } else { ?>Email<? } ?>*</div>
                        <input type="email" name="email"/>
                    </div>
                    <?
                }
                if ($this->inputPhone) {
                    ?>
                    <div class="form_item_container">
                        <div class="form_item_description"><? if ($this->page->getPageLanguage() == "it") { ?>Telefono<? } else { ?>Phone<? } ?></div>
                        <input type="text" name="phone"/>
                    </div>
                    <?
                }
                ?>
                <div class="form_item_container_checkbox">
                    <div class="form_item_description">
                        <? if ($this->page->getPageLanguage() == "it") { ?>Accetto la privacy policy consultabile a questo <a href="<?= $this->privacy_url ?>">link</a>* <? } else { ?>I accept the privacy policy found at this <a href="<?= $this->privacy_url ?>">link</a>*<? } ?>
                        <input type="checkbox" name="privacy-checkbox" id="form-privacy-checkbox"/>
                    </div>
                </div>
                <div class="submit_button_container">
                    <input type="submit" class="button" value="<?
                        switch ($this->sendPeriod) {
                            case "reg":
                                if ($this->page->getPageLanguage() == "it") {
                                    ?>Iscriviti<?
                                } else {
                                    ?>Subscribe<?
                                }
                                break;
                            case "send":
                                if ($this->page->getPageLanguage() == "it") {
                                    ?>Invia<?
                                } else { 
                                    ?>Send<?
                                }
                                break;
                            case "sendReq":
                                if ($this->page->getPageLanguage() == "it") {
                                    ?>Invia la richiesta<? } else { ?>Send request<?
                                }
                                break;
                        }
                        ?>">
                </div>
            </form>
            <div style="clear:both;"></div>
        </div>
        <?
    }

    /**
     * Method to get the heading tag
     * 
     * @return string
     */
    public function getHeadingTag() {
        return $this->headingTag;
    }

    /**
     * Method to set the heading tag
     * 
     * @param string $headingTag Title tag [h1, h2, ..., h6]
     * @return self
     */
    public function setHeadingTag($headingTag) {
        $this->headingTag = $headingTag;
        return $this;
    }
}