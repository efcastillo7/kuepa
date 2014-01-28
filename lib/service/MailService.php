<?php
class MailService {
  private static $instance = null;
  private $mailer;
 
  public static function getInstance() {
      if(!self::$instance) {
          self::$instance = new MailService;
      }
      return self::$instance;
  }

  public function find($id){
    return(MailMessage::getRepository()->find($id));
  }

  /**
  * @array $conds ['cond1 = ? OR cond2 = ?',$param1,$param2]
  */
  public function findAll($conds = array() ){
    $q = MailMessage::getRepository()->createQuery('m');
    if( count($conds) > 0 ){
      $q->where($conds);
    }      
    $q->orderBy('status asc, priority asc'); 
    return( $q->execute() );
  }


  public function save($params = array()){
     if( (int)$params['id'] > 0 ) {
       $mail_message = self::find($params['id']);
     }else{
       $mail_message = new MailMessage();
     }

    $mail_message->setProfileId($params['profile_id'])
                 ->setName($params['name'])
                 ->setSubject($params['subject'])
                 ->setEmail($params['email'])
                 ->setcontent($params['content'])
                 ->setPriority($params['priority'])
                 ->setStatus($params['status'])
                 ->save();
    return($mail_message);
  }

  public function delete($id){
    $mail = self::find($id);
    $mail->delete();
  }

  public function setTransport(){
    /**
     *  We can set the mail smtp server dinaamically
     *  Using db params. Multiple SMTP servers
     */
      $send_protocol = ""; //specific smtp configuration Configure in db on yml
      if( $send_protocol == "smpt" ){
        $this->mailer->isSMTP();      // Set mailer to use SMTP
        $this->mailer->Host = 'smtp.gmail.com';  // Specify main and backup server
        $this->mailer->Port = 587;
        $this->mailer->SMTPAuth = true;     // Enable SMTP authentication
        $this->mailer->Username = 'cyberfranco@gmail.com';  // SMTP username
        $this->mailer->Password = '13993051'; // SMTP password
        $this->mailer->SMTPSecure = 'tls';
      }else{ // mail
        // do nothing use default sendmail
      }
  }

  private function initMailer(){
    $this->mailer = new PHPMailer();
    $this->setTransport();
    $this->setFrom();
    $this->mailer->isHTML(true);  
  }

  public function setFrom(){
    /** We can take this from db */
    $this->mailer->From = 'soporte@kuepa.com';
    $this->mailer->FromName = 'Kuepa';
  }

  public function setTo($users_to = array()){
    // $users_to = ["mail@example","Name Example"]
    /** Also extract this from db */
    if (  sfConfig::get('sf_environment') == 'prod' ){

    }else{
      foreach ($users_to as $email => $name) {
        $this->mailer->addAddress($email, $name);  // Add a recipient
      }
    }
  }

  public function addCC($email){
    $this->mailer->addCC($email);
  }

  public function addBCC($email){
    $this->mailer->addBCC($email);
  }

  // TODO
  public function attachFiles($attachment = array() ){
    // http://swiftmailer.org/docs/messages.html#attaching-files
    $attachment = array();
    if( count( $attachments ) > 0){
      foreach ($attachments as $key => $full_path) {
        //$full_path /path/to/attach/file
        $this->mailer->addAttachment($full_path);
      }
    }
  }
 
  // This Method can be used
  // To send free mails now
  public function sendNow($email_to, $subject, $body, $name = "", $user_to_id = NULL){
    $params = array("profile_id" => $user_to_id,
          "name" => $name,
          "email" => $email_to,
          "subject" => $subject,
          "content" => $body,
          "priority" => 1);
    $email = $this->save($params);
    $this->sendMail($email->getId());
    return($email);
  }

  /**
  * @id MailMess
  */
  public function sendMail($id){
      $mail = $this->find($id);
      if ( $mail -> getStatus() == "pending"){
        $this->initMailer();
        $this->setTo( array( $mail->getEmail() => '' ) );

        $this->mailer->Subject = $mail->getSubject();//$mail->getSubject(); //Add field to store content;
        //$this->mailer->Body    = sfOutputEscaperArrayDecorator::unescape( $mail->getContent() );
        //$this->mailer->Body    = html_entity_decode( $mail->getContent() );
        $this->mailer->Body = $this->getTemplate($mail);

        //$mailer->AltBody = strip_tags($mail->getRaw('content'));

        if(!$this->mailer->send()) {
          //TODO: ADD Field to save error
          echo $error_msg = 'Message could not be sent. Mailer Error: ' . $this->mailer->ErrorInfo;
            return($error_msg);
         }else{
          $mail->setSentAt('NOW');
          $mail->setStatus('sent')->save();
         } 
      }

      return('Message has been sent');
  }

  /**
  *  ./symfony send:emails $limit
  */
  public function sendBatch($limit = 1){
    $q = MailMessage::getRepository()->createQuery('m')
          ->where('status = "pending"')
          ->orderBy('priority asc')
          ->limit($limit)
          ->execute();
    foreach($q as $key => $mail_message ){
      self::sendMail($mail_message->getId());
    }
  }

  public function getTemplate($mail_message){
    sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
    $body = get_partial("mail/email_templates/_template1",array("mail_message" => $mail_message));
    return($body);
  }

  /* TODO: Manage Templates */
  public function setTemplate(){

  }

/* TODO: Manage Templates */
  public function createTemplate(){ //--> HTML

  }

/* TODO: Manage Templates */
  public function setSchedule(){
   /*--> setTemplate
    template_id
    user
    date_to_send
    status -> peinding, sent, error
    */
  }
} 
