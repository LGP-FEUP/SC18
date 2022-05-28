import 'package:erasmus_helper/models/culture_category.dart';
import 'package:erasmus_helper/models/culture_entry.dart';
import 'package:erasmus_helper/views/social/cultural/components/category_widget.dart';
import 'package:erasmus_helper/views/social/cultural/culture_details.dart';
import 'package:erasmus_helper/views/social/cultural/culture_state.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'components/entry_widget.dart';

class CulturalTab extends StatelessWidget {
  const CulturalTab({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ChangeNotifierProvider<CultureState>(
        create: (_) => CultureState(),
        child: Stack(
          children: <Widget>[
            SingleChildScrollView(
              child: Padding(
                padding: const EdgeInsets.symmetric(vertical: 12),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: <Widget>[
                    Consumer<CultureState>(
                      builder: (context, cultureState, _) =>
                          SingleChildScrollView(
                        scrollDirection: Axis.horizontal,
                        child: Row(
                          children: <Widget>[
                            for (final category in cultureCategories)
                              CategoryWidget(category: category),
                          ],
                        ),
                      ),
                    ),
                    Consumer<CultureState>(
                      builder: (context, cultureState, _) => Column(
                        children: <Widget>[
                          for (final entry in entries.where((e) => e.categoryIds
                              .contains(cultureState.selectedCategoryId)))
                            GestureDetector(
                              onTap: () {
                                Navigator.of(context).push(
                                  MaterialPageRoute(
                                      builder: (context) => CultureDetails(
                                            entry,
                                          )),
                                );
                              },
                              child: EntryWidget(
                                entry: entry,
                              ),
                            )
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
