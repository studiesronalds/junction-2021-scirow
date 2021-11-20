import pandas as pd
import pprint

fn = r'/opt/storage/web/storage/db.json'
df = pd.read_json('/opt/storage/web/storage/db.json')
# print(df.head(5))
ap = 0;
ho = 0;

for n,d in df.houses.items():
	ho = ho + 1
	ap = 0
	for apartments in d['apartments']:
		ap = ap + 1

		print(apartments.keys())
		print(apartments['people'])
		#AttributeError: 'dict' object has no attribute 'head'

  		# saving the dataframe
		df = pd.DataFrame(apartments['Hydractiva_shower']['measurements'])
		df.to_csv("".join(('apartments', str(ap) , '-house', str(ho) , 'Hydractiva_shower.csv')))

		# print(apartments['Kitchen_optima_faucet'])
		df = pd.DataFrame(apartments['Kitchen_optima_faucet']['measurements'])
		df.to_csv("".join(('apartments', str(ap) ,  '-house', str(ho)  , 'Kitchen_optima_faucet.csv')))
		# print(apartments['Optima_faucet'])
		df = pd.DataFrame(apartments['Optima_faucet']['measurements'])
		df.to_csv("".join(('apartments', str(ap) , '-house', str(ho) , 'Optima_faucet.csv')))
		# print(apartments['Hydractiva_shower']['measurements'][:5]);
		# print(apartments['Hydractiva_shower']['measurements'][0].keys())
		# print(apartments['Washing_machine'])
		df = pd.DataFrame(apartments['Washing_machine']['measurements'])
		df.to_csv("".join(('apartments', str(ap) , '-house', str(ho) , 'Washing_machine.csv')))
		# print(apartments['Dishwasher'])
		df = pd.DataFrame(apartments['Dishwasher']['measurements'])
		df.to_csv("".join(('apartments', str(ap) , '-house', str(ho) , 'Dishwasher.csv')))


		# print(apartments['Kitchen_optima_faucet'])
		# print(apartments['Optima_faucet'])
		# print(apartments['Washing_machine'])
		# print(apartments['Dishwasher'])
		

# for x in df.houses:
# 	print(x)

# for houses in d['houses']:
#     for string in houses:
#         for co_name in co_names_df['Name']:
#             if string == co_name:
#                 co_names_index = co_names_df.loc[co_names_df['Name']=='string'].index
#                 co_names_df['Frequency'][co_names_index] += 1




# with open(fn) as f:
#     data = json.load(f)

# print(data.head(5))

# # some of your records seem NOT to have `Tags` key, hence `KeyError: 'Tags'`
# # let's fix it
# for r in data['Volumes']:
#     if 'Tags' not in r:
#         r['Tags'] = []

# v = pd.DataFrame(data['Volumes']).drop(['Attachments', 'Tags'],1)
# a = pd.io.json.json_normalize(data['Volumes'], 'Attachments', ['VolumeId'], meta_prefix='parent_')
# t = pd.io.json.json_normalize(data['Volumes'], 'Tags', ['VolumeId'], meta_prefix='parent_')

# v.to_sql('volume', engine)
# a.to_sql('attachment', engine)
# t.to_sql('tag', engine)