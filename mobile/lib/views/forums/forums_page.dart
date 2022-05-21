import 'package:erasmus_helper/models/forumCategory.dart';
import 'package:erasmus_helper/models/forumEntry.dart';
import 'package:erasmus_helper/views/forums/components/category_widget.dart';
import 'package:erasmus_helper/views/forums/forums_state.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'components/entry_widget.dart';

class ForumsPage extends StatelessWidget {
  const ForumsPage({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ChangeNotifierProvider<ForumsState>(
        create: (_) => ForumsState(),
        child: Stack(
          children: <Widget>[
            SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: <Widget>[
                  Padding(
                    padding: const EdgeInsets.symmetric(
                        horizontal: 8.0, vertical: 8.0),
                    child: Consumer<ForumsState>(
                      builder: (context, forumsState, _) =>
                          SingleChildScrollView(
                        scrollDirection: Axis.horizontal,
                        child: Row(
                          children: <Widget>[
                            for (final category in forumCategories)
                              CategoryWidget(category: category),
                          ],
                        ),
                      ),
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 16.0),
                    child: Consumer<ForumsState>(
                      builder: (context, forumsState, _) => Column(
                        children: <Widget>[
                          for (final entry in entries.where((e) => e.categoryIds
                              .contains(forumsState.selectedCategoryId)))
                            ForumWidget(
                              entry: entry,
                            )
                        ],
                      ),
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
