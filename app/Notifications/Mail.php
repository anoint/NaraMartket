use Webklex\IMAP\Client;
 
$oClient = new Client([
    'host'          => 'pop3s.hiworks.com',
    'port'          => 995,
    'encryption'    => 'ssl',
    'validate_cert' => true,
    'username'      => 'jnyou@everytalk.co.kr',
    'password'      => 'j94381600*',
    'protocol'      => 'pop3'
]);
 
//Connect to the IMAP Server
$oClient->connect();
 
//Get all Mailboxes
/** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
$aFolder = $oClient->getFolders();
 
//Loop through every Mailbox
/** @var \Webklex\IMAP\Folder $oFolder */
foreach($aFolder as $oFolder){
 
    //Get all Messages of the current Mailbox $oFolder
    /** @var \Webklex\IMAP\Support\MessageCollection $aMessage */
    $aMessage = $oFolder->messages()->all()->get();
    
    /** @var \Webklex\IMAP\Message $oMessage */
    foreach($aMessage as $oMessage){
        echo $oMessage->getSubject().'<br />';
        echo 'Attachments: '.$oMessage->getAttachments()->count().'<br />';
        echo $oMessage->getHTMLBody(true);
    }
}