import pandas
import matplotlib.pyplot as plt
from sqlalchemy import create_engine
import pymysql

import os
hostname = os.environ['DB_HOST']
database = os.environ['DB_DATABASE']
username= os.environ['DB_USERNAME']
password= os.environ['DB_PASSWORD']

##engine = create_engine("mysql:///" + username  + ":" + password  + "@" + hostname + "/" + database  + "?charset=utf8")


sqlEngine = create_engine('mysql+pymysql://' + username + ':' + password + '@' + hostname + ':3306', pool_recycle=20334)
dbConnection = sqlEngine.connect()
#contentTypes = pd.read_sql("select * from scraper.content_types", dbConnection);
#content = pd.read_sql("select " + database + ".external_contents.* , scraper.content_types.name as typename from scraper.external_contents left join scraper.content_types on scraper.content_types.id = scraper.external_contents.content_type_id", dbConnection);


df = pandas.read_sql("SELECT * , MONTH(created_at) as month, CONCAT(MONTH(created_at), YEAR(created_at)) as monthyear , CONCAT(MONTH(created_at), YEAR(created_at), DAY(created_at)) as monthyearday  FROM " + database + ".measurement", sqlEngine)


# df['consumption'].plot(kind='hist', figsize=(8,5))

# print(df.info())
# print(df.describe(include='all'))


# Data columns (total 9 columns):
#  #   Column             Non-Null Count   Dtype         
# ---  ------             --------------   -----         
#  0   id                 311093 non-null  int64         
#  1   type               311093 non-null  object        
#  2   apartment_id       311093 non-null  int64         
#  3   consumption        311093 non-null  int64         
#  4   temp               311093 non-null  object        
#  5   flow_time          311093 non-null  object        
#  6   power_consumption  311093 non-null  object        
#  7   created_at         311093 non-null  datetime64[ns]
#  8   updated_at         311093 non-null  datetime64[ns]


#Heavy

# print(pandas.crosstab(df['apartment_id'], df['consumption']))
# print(pandas.crosstab(df['consumption'], df['power_consumption']))
# print(pandas.crosstab(df['type'], df['consumption']))

#Grouping 
pandas.set_option('display.max_rows', None)
#print(df[['consumption','temp', 'flow_time', 'type','apartment_id']].groupby(['type','apartment_id']).mean())

#print(df[['consumption','temp', 'flow_time', 'type','apartment_id']].groupby(['type','apartment_id']).mean())
# -- /opt/projects/hackathons/junction2021/storage/mean_per_type_per_apartament.txt

#print(df[['consumption','temp', 'flow_time', 'type','apartment_id', 'monthyear']].groupby(['type','monthyear']).mean())
# -- /opt/projects/hackathons/junction2021/storage/mean_per_type_per_apartament.txt

#print(df[['consumption','temp', 'flow_time', 'type','apartment_id', 'monthyear']].groupby(['apartment_id','monthyear']).mean())
# -- /opt/projects/hackathons/junction2021/storage/mean_consumption_per_monthyear.txt

#print(df[['consumption','temp', 'flow_time', 'type','apartment_id', 'monthyear']].groupby(['apartment_id','monthyear']).mean())
# -- /opt/projects/hackathons/junction2021/storage/mean_consumption_per_monthyear.txt

print('MIN')
print(df[['consumption','temp', 'flow_time', 'type','apartment_id', 'monthyearday']].groupby(['apartment_id','monthyearday', 'type']).min())
# -- /opt/projects/hackathons/junction2021/storage/mean_consumption_per_monthyear.txt

print('MAX')
print(df[['consumption','temp', 'flow_time', 'type','apartment_id', 'monthyearday']].groupby(['apartment_id','monthyearday', 'type']).max())

print('AVERAGE')
print(df[['consumption','temp', 'flow_time', 'type','apartment_id', 'monthyearday']].groupby(['apartment_id','monthyearday', 'type']).mean())