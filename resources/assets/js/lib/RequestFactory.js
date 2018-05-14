import JobRequest from '../request/JobRequest';
import CompanyRequest from '../request/CompanyRequest';
import CampaignRequest from '../request/CampaignRequest';
import AnnouncementRequest from '../request/AnnouncementRequest';
import ReservationRequest from '../request/ReservationRequest';
import AdminRequest from '../request/AdminRequest';
import MasterdataRequest from '../request/MasterdataRequest';
import HomeRequest from '../request/HomeRequest';
import SpecialPromotionRequest from '../request/SpecialPromotionRequest';
import UploadFile from '../request/UploadFile';
import ApplicantRequest from '../request/ApplicantRequest';
import AnalysisRequest from '../request/AnalysisRequest';
import CandidateRequest from '../request/CandidateRequest';
import CertificateRequest from '../request/CertificateRequest';
import MessageRequest from '../request/MessageRequest';
import UserCandidateRequest from '../request/UserCandidateRequest';
import CertificateGroupRequest from '../request/CertificateGroupRequest';

const requestMap = {
  AnalysisRequest,
  JobRequest,
  AdminRequest,
  CompanyRequest,
  CampaignRequest,
  AnnouncementRequest,
  ReservationRequest,
  MasterdataRequest,
  HomeRequest,
  SpecialPromotionRequest,
  UploadFile,
  ApplicantRequest,
  CandidateRequest,
  CertificateRequest,
  MessageRequest,
  UserCandidateRequest,
  CertificateGroupRequest,
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
