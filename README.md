# webCrawler
对b站数据进行爬取，通过网页进行数据的展示
北京化工大学

生产实习课程设计报告






课程设计题目：预测动漫评分及分析动漫更容易火爆的风格




摘   要

简要介绍课程设计内容

本课程设计通过爬取B站的动漫评论、弹幕、评分、播放量等数据，通过数据分析实现预测新出的动漫评分及分析动漫更容易火爆的风格。
结论

1、情感值越高、播放量收藏量越多的动漫评分也越高；

2、近几年来，从各大网络IP改编的动漫作品人气高涨，国漫的崛起一方面在于优秀改编的助力，一方面也在于优质的画面、美术、动作设计，而那些搞笑、热血、战斗风格的动漫经久不衰，而从风格搭配上看，【玄幻 热血 战斗】、【搞笑 原创 日常】、【改编 热血 战斗】类的动漫受众很广，也为我们指示了发展和创新的方向。




第一章 项目背景及意义
1.1项目背景
近年以来，我国动漫内容生产实力得到了进一步提升，类型题材日趋多元化，在国家政策和资金的保驾护航下，动漫产业呈现出繁荣的景象。但不可否认的是，外来的动漫文化依然在我国的动漫行业占有极大的比列，相较而言，我国虽然通过动漫有优秀的对外文化输出，但占比较小。分析预测动漫的质量和风格趋向，对动漫产业的发展有战略性意义。归根结底，我们要在某个行业拥有竞争力，必需在潮流风格的选择中添加的优秀的民族文化，打造属于自己的独有的风格，增强核心竞争力。
1.2本课题主要研究内容
1、对评论、弹幕进行关键字提取和情感值分析，分析出的值于动漫的评分高低、播放量、收藏量等有明显关联价值。
2、通过情感值和评分等数据，分析出的结果可以用于在未知动漫评分、已有动漫评论和播放量等数据的情况下，对动漫的评分进行预测，可以对后期宣传、广告投资等关乎商业价值的运动有所指向。
3、通过对火爆动漫不同风格搭配的频繁项的分析，可以看出近几年来什么样的风格最受欢迎的，从而在制作动漫时引入，增加受众，提升动漫收益。
第二章 项目实施方法设计
2.1 技术路线
编程语言的选择：
数据的爬取：python（核心packge:requests，beautifulsoup）
数据的分析处理：python（核心packge:xlrd，xlwt，pandas，re）
数据库：1.  python实现数据上传
2.mysql数据存储
网页：前端：html，JavaScript，echarts，css，ajax，
  框架：layui
后台：php，python

2.实现的步骤：数据的爬取->对爬取数据的解析->数据库的建立->数据上传
->数据的展示

2.2 数据爬取
网页的请求用的是python requests库，对网页进行爬取。获得html格式的网页。
总共爬取了以下几部分的网页

b站国漫排行榜数据，目的：获取综合评分，排行名次，播放量，收藏数，评论数量
https://www.bilibili.com/v/popular/rank/guochan

动漫主页的数据，目的：获取动漫BV号
https://www.bilibili.com/bangumi/play/ss1733

动漫详细介绍的网页 目的：获得弹幕总数，系列追番人数，动漫风格
https://www.bilibili.com/bangumi/media/md1733/?spm_id_from=666.25.b_6d656469615f6d6f64756c65.2

通过API接口获得动漫评论
https://api.bilibili.com/x/v2/reply?pn="+str(page)+"&type=1&oid="+self.oid+"&mode=3&plat=1&_=1625454436599

通过API接口获得动漫弹幕
https://api.bilibili.com/x/player/pagelist' 

 数据总共有两种格式：
（1）所爬取的数据是HTML格式，则用beautifulsoup库来解析网页获取关键信息或者用正则表达式来解析网页。
（2）所爬取的数据是Json格式，则用json库来解析数据，获得关键信息。


2.3 数据库搭建
数据库采用的是阿里云mysql云端数据库
通过爬取的数据，建立了6个表
（1）管理员日志表
用于存放管理员对于数据的操作，增删改查。
（2）弹幕表，用来存放所爬取动漫的弹幕

（3）评论表
用来存放爬取的评论，动漫名称，评论人，评论点赞数，评论内容，评论时间
总共爬取了100部动漫，超过100w条评论。


（4）展览表
其中的image用的是longblob总段，来存储大型图片，position和radar用json字存储图表字段





（5）排行榜表

存储的是爬取的排行榜信息。

（6）用户表
存储的是登录管理界面的信息。

2.4 数据的分析
1.数据的聚类分析
根据评分和计算出来的情感总值，对不动的动漫进行聚类处理，把不同的动漫分成五类并展示出来。
2.动漫的风格关联分析
根据爬取的动漫风格，对一百部动漫进行关联规则的挖掘
待完成
3.动漫的情绪分布分析
用情感分析包对所爬取的评论进行情感分析，其中用到了词的分割包jieba来对没一部动漫的每一条评论分词，然后用情感分析包得出每一条评论的情感值。最后在计算出每部动漫的情感总值。
4.弹幕云图的生成
对爬取的弹幕先分词，然后用wordcloud得出弹幕词云图
5.动漫数据的预测
Knn？
				待完成	

2.5 数据的展示
采用B\S架构，展示数据前端的网页页面分为6个部分
1.用户管理，可以添加用户，管理用户，还能对管理员日志进行管理

2.评论展示，对存在数据库的评论进行修改和删除的操作
3.弹幕展示，对存在数据库的弹幕进行修改和删除的操作
4.数据分析：	1）对整合好的排行榜数据进行展示。
2）每部动漫的综合分析雷达图，情感分布折线图，弹幕词云图进行展示。
								展示风格分布图
3）对所有爬取的动漫进行情感值的展示
4）情感聚类展示
5）每部动漫的情感总值展示

5.预测的实现：根据输入的情绪值、播放量、评论数、收藏数，输出预测的评分	


第三章 项目实现与测试
3.1 项目1——基于情感词典的情感分析
3.1.1 项目源代码分析
通过情感打分的方式（波森情感词典BosonNLP_sentiment_score）进行文本情感极性判断，score > 0判断为正向，score < 0判断为负向。
代码如下：
df = pd.read_table("BosonNLP_sentiment_score.txt",sep= " ",names=['key','score'])#将词库的两列数据（关键词和分值）读入
key = df['key'].values.tolist()
score = df['score'].values.tolist()

def getscore(line):
    segs = jieba.lcut(line)  #分词
    score_list  = [score[key.index(x)] for x in segs if(x in key)]
    return  sum(score_list)  #累计每个句子中分词的得分
data=open("情感值data.txt",'w+') 
with open("弹幕.txt","r",encoding="utf-8") as f: 
    k = 0
    for line in f:
        print(round(getscore(line),2),file=data)
  #读取每条文本数据，并累计每条数据的情感值，插入数据库
data.close()
该过程是对文档分词，找出文档中的情感词、否定词以及程度副词，然后判断每个情感词之前是否有否定词及程度副词，将它之前的否定词和程度副词划分为一个组，如果有否定词将情感词的情感权值乘以-1，如果有程度副词就乘以程度副词的程度值，最后所有组的得分加起来，大于0的归于正向，小于0的归于负向。

3.1.2 项目实现效果






3.1.3 项目难点分析
用这种方法有明显的不足之处：词典把所有常用词都打上了唯一分数。首先，不带情感色彩的停用词会影响文本情感打分，而且由于中文的博大精深，词性的多变和情感程度在不同语境下的区分也影响了模型准确度。因此通过打分的方式判断文本的情感正负在一定程度上有不准确性。
解决方法：有选择地剔除文本信息，尽量避免无意义的计分。

3.2 项目2——调用knn算法的机器学习法
3.2.1 项目源代码分析
KNN的原理就是当预测一个新的值x的时候，根据它距离最近的K个点是什么类别来判断x属于哪个类别
代码如下：
def classify0(inX, dataSet, labels, k):
    """
    :param inX: 用于分类的输出向量
    :param dataSet:输入的样本集
    :param labels:标签向量
    :param k:用于选择最近邻居的树目
    :return:
    """
    dataSetsize = 100  # 得到数据集的行数
    diffMat = tile(inX, (dataSetsize, 1)) - dataSet  # tile生成和训练样本对应的矩阵，并与训练样本求差
    sqDiffMat = diffMat ** 2
    sqDistances = sqDiffMat.sum(axis=1)  # 将矩阵的每一行相加
    distances = sqDistances ** 0.5
    sortedDistIndicies = distances.argsort()  # 从小到大排序 返回对应的索引位置
    classCount = {}
    for i in range(k):
        voteIlabel = labels[sortedDistIndicies[i]]  # 找到该样本的类型
        classCount[voteIlabel] = classCount.get(voteIlabel, 0) + 1  # 在字典中将该类型加一
    sortedClassCount = sorted(classCount.items(), key=operator.itemgetter(1), reverse=True)  # reverse = True代表降序
    return sortedClassCount[0][0]  # 排序并返回出现最多的那个类型
3.2.2 项目实现效果

3.2.3 项目难点分析
由于KNN算法是对所有点都进行距离计算，对于一些不相关的功能和数据规模也同样敏感，当不相关因素占比较大是，影响预测的准确性。
解决方法：借用验证性因子分析的方法，证明爬取动漫数据的中的【文本情感值 播放量 追番人数 评分人数 收藏量 评论数 综合评分中】对动漫最终评分有预测性的数据是【文本情感值 播放量 收藏量 评论数】，选定这些相关因子，可以提高评分预测的准确性。


3.3 项目3——挖掘出风格搭配的潜在价值
3.3.1 项目源代码分析
挖掘频繁项集由Apriori算法实现，：先找出所有的频繁项集，再从频繁项集中找出符合最小置信度的项集，此处最小置信度为0.5
#coding=utf-8                        # 全文utf-8编码
import sys
import readin
def apriori(D, minSup):
	'''频繁项集用keys表示，
	key表示项集中的某一项，
	cutKeys表示经过剪枝步的某k项集。
	C表示某k项集的每一项在事务数据库D中的支持计数
	'''
	C1 = {}
	for T in D:
		for I in T:
			if I in C1:
				C1[I] += 1
			else:
				C1[I] = 1
	print (C1)
	_keys1 = C1.keys()
	keys1 = []
	for i in _keys1:
		keys1.append([i])
	n = len(D)
	cutKeys1 = []
	for k in keys1[:]:
		if C1[k[0]]*1.0/n >= minSup:
			cutKeys1.append(k)
	cutKeys1.sort()
	keys = cutKeys1
	all_keys = []
	while keys != []:
		C = getC(D, keys)
		cutKeys = getCutKeys(keys, C, minSup, len(D))
		for key in cutKeys:
			all_keys.append(key)
		keys = aproiri_gen(cutKeys)
	return all_keys
def getC(D, keys):
	'''对keys中的每一个key进行计数'''
	C = []
	for key in keys:
		c = 0
		for T in D:
			have = True
			for k in key:
				if k not in T:
					have = False
			if have:
				c += 1
		C.append(c)
	return C

def getCutKeys(keys, C, minSup, length):
	'''剪枝步'''
	for i, key in enumerate(keys):
		if float(C[i]) / length < minSup:
			keys.remove(key)
	return keys
def keyInT(key, T):
	'''判断项key是否在数据库中某一元组T中'''
	for k in key:
		if k not in T:
			return False
	return True
def aproiri_gen(keys1):
	'''连接步'''
	keys2 = []
	for k1 in keys1:
		for k2 in keys1:
			if k1 != k2:
				key = []
				for k in k1:
					if k not in key:
						key.append(k)
				for k in k2:
					if k not in key:
						key.append(k)
				key.sort()
				if key not in keys2:
					keys2.append(key)
			
	return keys2
D = readin.reget()
F = apriori(D, 0.5)#读入数据集D，置信度设置为0.5
print( '\nfrequent itemset:\n', F)

3.3.2 项目实现效果













3.3.3 项目难点分析
置信度的设置太高和太低都会 影响最终的效果，需要结合实际情况多次实验，找出最合适的置信度。
第四章 结论与展望
本次课程设计的完成整体而言不算很难，小组在项目确定、开展到完成的整个过程中都做到了相互讨论、相互学习，遇到困难共同解决，但由于对python的不甚熟练和对数据分析较为粗浅的了解，我们的课设内容还是没有做到尽善尽美，由于社会经验少，对动漫行业发展的情况眼界有限，所以能设计解决问题的层次也较浅，但通过本次的学习实践过程，也让我们对python更加掌握，对文本挖掘的方法、意义和过程也有了进一步的了解，以及对图形化插件的初次使用，也拓宽了知识面，所以这是一次及有意义的学习实践，让我们有了更多的知识和更熟练的技能，期待在未来可以深刻的学习了解到文本挖掘和数据分析的知识，以便应用到未来的工作学习中，提升自我的核心竞争力，为社会做一点贡献，实现自我的价值。
第五章 参考资源
情感分析：
https://blog.csdn.net/weixin_43886356/article/details/105449971
https://blog.csdn.net/weixin_52369770/article/details/117633629?utm_medium=distribute.pc_aggpage_search_result.none-task-blog-2~aggregatepage~first_rank_v2~rank_aggregation-2-117633629.pc_agg_rank_aggregation&utm_term=bosonnlp+%E6%83%85%E6%84%9F%E5%88%86%E6%9E%90&spm=1000.2123.3001.4430
https://blog.csdn.net/luoluopan/article/details/88938742?utm_medium=distribute.pc_relevant.none-task-blog-baidujs_baidulandingword-0&spm=1001.2101.3001.4242
Pandas库:
https://www.cnblogs.com/reaptomorrow-flydream/p/9178362.html
NLP库：
https://blog.csdn.net/alexkx/article/details/84998438
因子分析：
https://www.zhihu.com/question/40981105
https://zhuanlan.zhihu.com/p/62494582
https://blog.csdn.net/FightingBob/article/details/105518763
KNN算法：
https://www.cnblogs.com/listenfwind/p/10311496.html
https://blog.csdn.net/hajk2017/article/details/82862788
https://www.cnblogs.com/ybjourney/p/4702562.html
可视化：
https://blog.csdn.net/qq_41793928/article/details/107552456
Apriori算法：
https://blog.csdn.net/lbweiwan/article/details/82725466
beautifulsoup库：
https://beautifulsoup.readthedocs.io
数据爬取：
https://blog.csdn.net/weixin_41108515/article/details/106185113
https://blog.csdn.net/weixin_44659084/article/details/115448133
数据可视化：
https://blog.csdn.net/weixin_38208912/article/details/88937334
文件操作：
https://www.cnblogs.com/zhenwei66/p/8406201.html
Echarts：
https://echarts.apache.org/zh/tutorial.html
https://blog.csdn.net/weixin_42528855/article/details/95732754
数据库环境搭建：
https://www.cnblogs.com/anywherego/p/5085852.html
https://blog.csdn.net/weixin_41605937/article/details/103639371
https://www.csdn.net/tags/Mtjakg1sODY2MzUtYmxvZwO0O0OO0O0O.html
网页框架搭建：
https://www.cnblogs.com/zbspace/p/11716621.html
https://www.cnblogs.com/hellangels333/p/9059770.html
https://developer.mozilla.org/zh-CN/docs/Learn/Getting_started_with_the_web
https://www.cnblogs.com/yad123/p/11563069.html
第六章 组员课题完成情况详细说明
