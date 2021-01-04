# coding: utf-8

#######  ライブラリのインポート  #######
import time  # 時間待機などのライブラリ
import datetime  # 時刻などのライブラリ
import csv  # CSV操作系のライブラリ
from selenium import webdriver  # selenium本体
# from selenium.webdriver.common.alert import Alert  # ダイアログ操作のためのクラス
# from selenium.webdriver.support import expected_conditions
# from selenium.webdriver.support.ui import WebDriverWait
# from selenium.webdriver.support.select import Select  # セレクトボックス操作のためのクラス
# from selenium.webdriver.common.by import By


#######  クラスの定義  #######
class Job():
    """
    Persolの案件情報に関するクラス
    """

    def __init__(self, job_id):

        self.url = ""
        self.title = ""
        self.job_id = job_id
        self.type = ""
        self.tips = ""
        self.wage = ""
        self.occupation = ""
        self.industry = ""
        self.work_location = ""
        self.description = ""
        self.skill = ""
        self.hours = ""
        self.holiday = ""
        self.working_period = ""
        self.working_info = ""
        # self.contact = ""

    def getArray(self):
        """
        案件情報の1次配列を取得するクラスメソッド
        """
        target_array = [
            self.url,
            self.title,
            self.job_id,
            self.type,
            self.tips,
            self.wage,
            self.occupation,
            self.industry,
            self.work_location,
            self.description,
            self.skill,
            self.hours,
            self.holiday,
            self.working_period,
            self.working_info,
            # self.contact,
        ]
        return target_array


class Persol():
    """
    Persolの案件データ取得のためのクラス
    """
    ### ChromeDriverのフルパス ###
    CHROME_DRIVER_PATH = "C:/Project/python/selenium/getPersol/chromedriver.exe"
    FILE_PATH = "C:/Project/python/selenium/getPersol/"

    # CHROME_DRIVER_PATH = "/var/www/html/portfolio/getPersol/chromedriver.exe"
    # FILE_PATH = "../"
    persol_URL = "https://persol-tech-s.co.jp/jobsearch/result/A1knt/A2tky/J2apdev_J2nwcons/?displayCount=100"
    # persol_URL = "https://persol-tech-s.co.jp/jobsearch/result/A1knt/A2tky/J2apdev_J2nwcons/?displayCount=10"

    def __init__(self):
        print("\n=======  ブラウザ(ドライバ)を起動します  =======")
        # ChromeDriverのパスを引数に指定しChromeを起動
        self.driver = webdriver.Chrome(self.CHROME_DRIVER_PATH)

        self.array_ID = []
        self.obj_job = {}

    def getHeaderInfo(self):
        """
        CSVファイル出力のためのヘッダ配列を取得するクラスメソッド
        """
        header_line = [
            "url",
            "title",
            "job_id",
            "type",
            "tips",
            "wage",
            "occupation",
            "industry",
            "work_location",
            "description",
            "skill",
            "hours",
            "holiday",
            "working_period",
            "working_info",
            # "contact",
        ]
        return header_line

    def addArrayIDFromListPage(self):
        """
        【案件一覧ページ】から【案件ID】と【案件名】の辞書を取得するクラスメソッド
        """
        print("\n=== 案件一覧ページにアクセスします ===")
        ### パーソルの案件情報一覧ページにアクセス ##
        self.driver.get(self.persol_URL)

        print("=== 案件ID一覧を取得します ===")
        job_card_num_elements = self.driver.find_elements_by_class_name(
            "p-job-card__number")
        for job_card_num_element in job_card_num_elements:
            job_number = job_card_num_element.text
            job_number = job_number.replace("お仕事No.", "")
            self.array_ID.append(job_number)

    def getJobInfoFromID(self, target_ID):
        """
        【案件ID】の案件ページにアクセスして【案件詳細情報】を取得するクラスメソッド
        """
        print("\n=== 案件IDの案件ページにアクセスします ===")
        print("対象ID：" + target_ID)
        base_URL = "https://persol-tech-s.co.jp/jobsearch/workDetail_index.html?job_offer_id="
        target_URL = base_URL + target_ID
        self.driver.get(target_URL)

        print("=== 案件情報を取得します ===")
        job = Job(target_ID)
        job.url = target_URL
        # print("・案件名")
        breadcrumbs_link_elements = self.driver.find_elements_by_class_name(
            "p-breadcrumbs__link")
        job.title = breadcrumbs_link_elements[5].text
        # print(job.title)

        # print("・タイプ")
        detail_icon_elements = self.driver.find_elements_by_class_name(
            "p-job-detail__icon")
        job.type = detail_icon_elements[0].text
        # print(job.type)

        # print("・おすすめポイント")
        job_tips_element = self.driver.find_element_by_class_name(
            "p-job-detail__point-data")
        job.tips = job_tips_element.text
        # print(job.tips)

        # print("=== 表の情報を取得します ===")
        job_detail_elements = self.driver.find_elements_by_class_name(
            "p-job-detail__data")

        # print("・給与")
        job.wage = job_detail_elements[0].text
        # print(job.wage)

        # print("・職種")
        job.occupation = job_detail_elements[1].text
        # print(job.occupation)

        # print("・業種")
        job.industry = job_detail_elements[2].text
        # print(job.industry)

        # print("・勤務地")
        job.work_location = job_detail_elements[3].text
        # print(job.work_location)

        # print("・仕事内容")
        job.description = job_detail_elements[4].text
        # print(job.description)

        # print("・活かせるスキル")
        job.skill = job_detail_elements[5].text
        # print(job.skill)

        # print("・勤務時間")
        job.hours = job_detail_elements[6].text
        # print(job.hours)

        # print("・休日")
        job.holiday = job_detail_elements[7].text
        # print(job.holiday)

        # print("・勤務期間")
        job.working_period = job_detail_elements[8].text
        # print(job.working_period)

        # print("・職場について")
        job.working_info = job_detail_elements[9].text
        # print(job.working_info_info)

        # print("・お問い合わせ先")
        # job.contact = job_detail_elements[11].text
        # print(job.contact)
        job_info = job.getArray()
        return job_info

    def setJobInfoFromArrayID(self):
        """
        クラスメソッド
        """
        print("\n=== 【案件ID】毎に【案件情報】を配列として取得します ===")
        for job_id in self.array_ID:
            job_iinfo = self.getJobInfoFromID(job_id)
            self.obj_job[job_id] = job_iinfo

    def saveCSV(self):
        """
        【案件詳細情報】の一覧をCSVファイルに保存するクラスメソッド
        """
        print("\n=== 【案件情報の配列】をCSVに保存します ===")

        dt_now = datetime.datetime.now()
        now =  dt_now.strftime('_%y%m%d_%H%M')
        output_filename = "persol" + now + ".csv"
        save_data = []
        save_data.append(self.getHeaderInfo())
        for job_id in self.obj_job:
            line = self.obj_job[job_id]
            save_data.append(line)

        with open(self.FILE_PATH + output_filename, 'w', newline="", encoding='utf-8') as file:
            writer = csv.writer(file, delimiter=",", quotechar='"')
            writer.writerows(save_data)
