from lxml import html
import requests

for x in range(2500):
	page = requests.get("http://pimp.name/hacker-name-generator/")
	tree = html.fromstring(page.content)
	name = tree.xpath('//div[@class="namename"]/text()')
	print 'name: ', name[0].strip(' \n\t')
	with open("hacker_name.txt", "a") as myfile:
		myfile.write(name[0].strip(' \n\t'))
		myfile.write("\n")
