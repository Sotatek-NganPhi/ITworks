import JobRequest from '../request/JobRequest';
import CompanyRequest from '../request/CompanyRequest';
import ExpoRequest from '../request/ExpoRequest';
import CampaignRequest from '../request/CampaignRequest';
import AnnouncementRequest from '../request/AnnouncementRequest';
import ReservationRequest from '../request/ReservationRequest';
import AdminRequest from '../request/AdminRequest';
import MasterdataRequest from '../request/MasterdataRequest';
import HomeRequest from '../request/HomeRequest';
import PickupRequest from '../request/PickupRequest.js';
import SpecialPromotionRequest from '../request/SpecialPromotionRequest';
import UploadFile from '../request/UploadFile';
import LinkRequest from '../request/LinkRequest';
import ApplicantRequest from '../request/ApplicantRequest';
import AnalysisRequest from '../request/AnalysisRequest';
import CandidateRequest from '../request/CandidateRequest';
import AutoMailRequest from '../request/AutoMailRequest';
import MailLogsRequest from '../request/MailLogsRequest';
import CertificateRequest from '../request/CertificateRequest';
import MessageRequest from '../request/MessageRequest';
import UserCandidateRequest from '../request/UserCandidateRequest';
import CertificateGroupRequest from '../request/CertificateGroupRequest';
import VideoRequest from '../request/VideoRequest';
import InterviewRequest from '../request/InterviewRequest';
import CategoryInterviewRequest from '../request/CategoryInterviewRequest';

const requestMap = {
  AnalysisRequest,
  JobRequest,
  AdminRequest,
  CompanyRequest,
  ExpoRequest,
  CampaignRequest,
  AnnouncementRequest,
  ReservationRequest,
  MasterdataRequest,
  HomeRequest,
  PickupRequest,
  SpecialPromotionRequest,
  UploadFile,
  LinkRequest,
  ApplicantRequest,
  CandidateRequest,
  AutoMailRequest,
  MailLogsRequest,
  CertificateRequest,
  MessageRequest,
  UserCandidateRequest,
  CertificateGroupRequest,
  VideoRequest,
  InterviewRequest,
  CategoryInterviewRequest,
};

export default class RequestFactory {

  static setCredentials(router, user) {
    RequestFactory._router = router;
    RequestFactory._user = user;
  }

  static getRequest(classname) {
    let RequestClass = requestMap[classname];
    if (!RequestClass) {
      throw new Error('Invalid request class name: ' + classname);
    }

    return new RequestClass(RequestFactory._router, RequestFactory._user);
  }

}
