# coding: utf-8
# ==================================================
# 実行関数の定義
# ==================================================

def main():
    """ 案件情報のCSVを取得する実行関数 """
    
    from models import Persol  # クラスモジュールのインポート
    persol = Persol()  # インスタンス生成

    persol.addArrayIDFromListPage(300)
    persol.setJobInfoFromArrayID()
    persol.saveCSV()

# ==================================================
# メインフロー
# ==================================================
if __name__ == "__main__":
    main()
