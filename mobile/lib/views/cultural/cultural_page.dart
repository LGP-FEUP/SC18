import 'package:erasmus_helper/models/cultureCategory.dart';
import 'package:erasmus_helper/models/cultureEntry.dart';
import 'package:erasmus_helper/views/cultural/components/category_widget.dart';
import 'package:erasmus_helper/views/cultural/culture_state.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'components/entry_widget.dart';

class CulturalPage extends StatelessWidget {
  const CulturalPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ChangeNotifierProvider<CultureState>(
        create: (_) => CultureState(),
        child: Stack(
          children: <Widget>[
            SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: <Widget>[
                  Padding(
                    padding: const EdgeInsets.symmetric(
                        horizontal: 8.0, vertical: 8.0),
                    child: Consumer<CultureState>(
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
                  ),
                  Consumer<CultureState>(
                    builder: (context, cultureState, _) => Column(
                      children: <Widget>[
                        for (final entry in entries.where((e) => e.categoryIds
                            .contains(cultureState.selectedCategoryId)))
                          EntryWidget(
                            entry: entry,
                          )
                      ],
                    ),
                  )
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
