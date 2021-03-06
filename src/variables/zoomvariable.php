<?php

    namespace fatfish\zoom\variables;

    use Composer\Package\Loader\ValidatingArrayLoader;
    use fatfish\zoom\Zoom;
    use Craft;
    class zoomvariable {
        protected $_MeetingId;
        protected $_Meeting;

        /**
         * @return mixed
         */
        public function list_meetings()
        {
            $settings = Zoom::$plugin->getSettings();
            if(empty($settings->Apikey) || empty($settings->ApiSecret) || empty($settings->HistoryToken))
            {
                Craft::$app->session->setNotice("Configure the plugins settings page with API");
                return;
            }


          return  Zoom::$plugin->zoomeeting->list_meetings();
        }

        /**
         * @param $MeetingId
         * @return array
         */
        public function get_meetingById($MeetingId)
        {
            $result=Zoom::$plugin->zoomeeting->get_meeting_details($MeetingId);
            $this->_Meeting=[
                    'topic'=>$result->topic,
                    'timezone'=>$result->timezone,
                    'start_time'=>$result->start_time,
                    'status'=>$result->status,
                    'start_meeting'=>$result->agenda,
                    'join_meeting'=>$result->join_url,
                    'join_meeting_byBrowser'=>"https://zoom.us/wc/join/$result->id",
                    'password'=>$result->password,
            ];
            return $this->_Meeting;
        }
    }
