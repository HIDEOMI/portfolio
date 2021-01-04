# coding: utf-8
#######  ライブラリのインポート  #######

#######  実行関数の定義  #######
def main():
    """ 処理のメインフロー """
    
    from models import Persol  # クラスモジュールのインポート
    persol = Persol()  # インスタンス生成

    persol.addArrayIDFromListPage()
    # id_ = "I-E201207034-IT"
    # persol.array_ID = [id_]
    # persol.getJobInfoFromID(id_)
    persol.setJobInfoFromArrayID()
    persol.saveCSV()


#######  メインフロー  #######
if __name__ == "__main__":
    main()
