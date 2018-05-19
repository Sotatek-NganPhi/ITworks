<?php

namespace App;

class Consts
{
    const DEFAULT_SQL_LIMIT = 10;
    const FIELD_TYPE_SYSTEM = 0;
    const FIELD_TYPE_FOREIGN_ID = 1;
    const FIELD_TYPE_CUSTOM = 100;
    // Html input types
    const INPUT_TYPE_TEXT = 1;
    const INPUT_TYPE_PASSWORD = 2;
    const INPUT_TYPE_RADIO = 3;
    const INPUT_TYPE_CHECKBOX = 4;

    const ACTION_CONTACT = 'contact';
    const ACTION_INQUIRY = 'inquiry';

    // TODO: remove this. Using repository config instead
    const PAGE_SIZE = 10;

    const FALSE = 0;
    const TRUE = 1;

    const THIS_MONTH = 1;
    const LAST_MONTH = 2;
    const TIME_ZONE_VIETNAM = "Asia/Ho_Chi_Minh";

    const SAMPLE_CSV_PATH_JOB_LIST = "/app/sample/JobList.csv";

    const BINARY_BASE = 2;

    const LIMIT_PER_PAGE = 10;
    const UN_READ = 0;
    const IS_READ = 1;
    const IS_FAVORITE = 2;
    const UN_FAVORITE = 0;

    const ALL_CATEGORIES = 'all';
    const INTERVIEW_LIMIT = 3;
    const INTERVIEW_PAGE_LIMIT = 6;

    const JOB_URGENT_INVALID = 0;
    const JOB_URGENT_VALID = 1;

    const TYPE_SYS_ADMIN        = 1;
    const TYPE_COMPANY_ADMIN    = 2;
    const GUARD_MANAGER = "manager";
}
