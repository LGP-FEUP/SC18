import 'package:erasmus_helper/services/group_service.dart';
import 'package:erasmus_helper/views/social/groups/components/group_card.dart';
import 'package:flutter/material.dart';

class GroupCarousel extends StatelessWidget {
  final String tagId;

  const GroupCarousel({Key? key, required this.tagId}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: GroupService.getGroupsWithTag(tagId),
      builder: (context, response) {
        if (response.connectionState == ConnectionState.done) {
          if (response.data != null) {
            String title = tagId;
            List groupIds = response.data as List<String>;

            if (groupIds.isEmpty) return Container();
            return _genCarrousel(title, groupIds);
          }
        }
        return Container();
      },
    );
  }

  Widget _genCarrousel(String title, List groupIds) {
    return Card(
        elevation: 0,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Padding(
              padding: const EdgeInsets.only(left: 10, top: 10, bottom: 10),
              child: Text(
                title,
                style:
                    const TextStyle(fontWeight: FontWeight.w500, fontSize: 23),
              ),
            ),
            SizedBox(
              height: 208,
              child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  itemCount: groupIds.length,
                  itemBuilder: (BuildContext context, int index) {
                    return GroupCard(groupId: groupIds[index]);
                  }),
            ),
          ],
        ));
  }
}
