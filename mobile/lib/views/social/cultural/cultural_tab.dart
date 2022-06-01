import 'package:erasmus_helper/models/culture_category.dart';
import 'package:erasmus_helper/services/culture_service.dart';
import 'package:flutter/material.dart';

import 'components/category_widget.dart';
import 'components/entry_widget.dart';
import 'culture_details.dart';

class CulturalTab extends StatefulWidget {
  const CulturalTab({Key? key}) : super(key: key);

  @override
  State<CulturalTab> createState() => _CulturalTabState();
}

class _CulturalTabState extends State<CulturalTab> {
  int _selectedIndex = 0;
  List<CultureCategory> categories = [
    CultureCategory("all", "All", Icons.circle)
  ];

  @override
  initState() {
    super.initState();
    CultureService.getCultureTags().then(
      (value) => setState(
        () {
          categories.addAll(value);
        },
      ),
    );
  }

  select(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Row(
          children: [
            SizedBox(
              height: 125,
              width: MediaQuery.of(context).size.width,
              child: Padding(
                padding: const EdgeInsets.symmetric(vertical: 12.0),
                child: ListView.builder(
                  itemCount: categories.length,
                  scrollDirection: Axis.horizontal,
                  itemBuilder: (BuildContext context, int index) {
                    return CategoryWidget(
                      category: categories[index],
                      index: index,
                      isSelected: index == _selectedIndex,
                      selectedCallback: select,
                    );
                  },
                ),
              ),
            ),
          ],
        ),
        FutureBuilder(
          future: _selectedIndex != 0
              ? CultureService.getCultureEntriesWithTag(
                  categories[_selectedIndex].categoryId)
              : CultureService.getAllCultureEntries(),
          builder: (context, response) {
            if (response.connectionState == ConnectionState.done) {
              if (response.data != null) {
                List cultureEntries = response.data as List;
                print(categories[_selectedIndex].categoryId);
                return Expanded(
                  child: ListView.builder(
                    itemCount: cultureEntries.length,
                    scrollDirection: Axis.vertical,
                    itemBuilder: (BuildContext context, int index) {
                      return GestureDetector(
                        onTap: () {
                          Navigator.of(context).push(
                            MaterialPageRoute(
                              builder: (context) => CultureDetails(
                                cultureEntries[index],
                              ),
                            ),
                          );
                        },
                        child: EntryWidget(
                          entry: cultureEntries[index],
                        ),
                      );
                    },
                  ),
                );
              }
            }
            return Container();
          },
        ),
      ],
    );
  }
}
